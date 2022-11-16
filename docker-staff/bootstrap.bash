#!/usr/bin/env bash

PREFIX="System bootstrap > "

echo "$PREFIX environment variables values:"
echo "> COMPOSER_INSTALL=$COMPOSER_INSTALL"
echo "> RUN_MIGRATION=$RUN_MIGRATION"
echo "> RUN_MYSQL=$RUN_MYSQL"
echo "> RUN_NPM=$RUN_NPM"
echo "> RUN_PHP_FPM=$RUN_PHP_FPM"

echo "> MYSQL_DATABASE=$MYSQL_DATABASE"
echo "> MYSQL_USER_NAME=$MYSQL_USER_NAME"
echo "> MYSQL_USER_PASSWORD=$MYSQL_USER_PASSWORD"
echo "> MYSQL_ROOT_PASSWORD=$MYSQL_ROOT_PASSWORD"

# Run RUN_NGINX
if [ "$RUN_NGINX" = true ]; then
    echo "$PREFIX service nginx start"
    service nginx start
    echo "$PREFIX service nginx status"
    service nginx status
fi


# Run RUN_MYSQL
if [ "$RUN_MYSQL" = true ]; then
    echo "-------------------------------------------------------------------------"
    echo "$PREFIX service mysql start"
    service mysql start
    echo "$PREFIX service mysql status"
    service mysql status

    echo "-------------------------------------------------------------------------"
    echo "$PREFIX create mysql user: $MYSQL_USER_NAME"
    mysql -uroot -e "CREATE USER '$MYSQL_USER_NAME'@'localhost' IDENTIFIED BY '$MYSQL_USER_PASSWORD';"
    echo "$PREFIX create mysql database $MYSQL_DATABASE"
    mysql -uroot -e "CREATE database $MYSQL_DATABASE;";
    echo "$PREFIX grant permissions to user: $MYSQL_USER_NAME"
    mysql -uroot -e "GRANT SELECT, INSERT, CREATE, DROP, UPDATE, ALTER ON $MYSQL_DATABASE.* TO '$MYSQL_USER_NAME'@'localhost';"
fi

echo "-------------------------------------------------------------------------"
echo "$PREFIX set dir rights"
echo "$PREFIX chown -R www-data:www-data /var/www"
chown -R www-data:www-data /var/www
echo "$PREFIX chmod -R 755 /var/www/storage"
chmod -R 755 /var/www/storage

# Run NPM INSTALL
if [ "$RUN_PHP_FPM" = true ]; then
    echo "-------------------------------------------------------------------------"
    echo "$PREFIX npm install"
    npm install
    npm run build
fi

# Run PHP FPM
if [ "$RUN_PHP_FPM" = true ]; then
  if [ ! -d /run/php ]; then
    echo "$PREFIX mkdir -p /run/php"
    mkdir -p /run/php
  fi

  echo "-------------------------------------------------------------------------"
  if [ "$COMPOSER_INSTALL" = true ]; then
      echo "$PREFIX composer install --no-dev"
      composer install --no-dev
  else
      echo "$PREFIX skip composer install"
  fi

  echo "-------------------------------------------------------------------------"
  FILE_ENV=./src/.env
  if [ -f "$FILE_ENV" ]; then
      VAR="$(cat ./src/.env | grep "^APP_KEY=")"
      LEN=${#VAR}
      if [ "$LEN" -lt 9 ]; then
          echo "$PREFIX php artisan key:generate"
          php artisan key:generate
      fi
  fi

  echo "-------------------------------------------------------------------------"
  if [ "$RUN_MIGRATION" = true ]; then
      echo "$PREFIX php artisan migrate"
      php artisan migrate
  else
      echo "$PREFIX skip run migrations"
  fi

  php artisan config:cache
  php artisan route:cache
  php artisan view:cache

  echo "-------------------------------------------------------------------------"
  echo "$PREFIX php-fpm8.1 -F -R"
  php-fpm8.1 -F -R
else
  echo "$PREFIX all done: dying"
fi