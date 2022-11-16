### Requirements
1. Docker
2. Docker Compose


### To run project without any presets, run:
```bash
bash install.bash 
```
which will prepare all environment by itself.

Project should be available on `localhost:8080`

### Or: to set your own .env variables:

1. copy .env.example file
```php
cp ./src/.env.example ./src/.env
```
2. set preferred DB values: 
```.env
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_user_password
```
3. Run install script:
```bash
bash install.bash 
```
4. Project should be available on `localhost:8080`

### To run tests
1. Enter in container
```bash
docker exec -it lemp bash
```
2. Install composer dependencies with dev dependencies
```bash
composer install
```
3. Run tests
```bash
./vendor/bin/phpunit
```

### If container is not getting up
1. Check container logs:
```bash
docker logs lemp -f
```

### Application details

Service bindings:

You can find application Contracts in `src/app/Logic/Contracts` directory.

Any contract is available bind to concrete class in `src/app/Providers/AppServiceProvider.php` file.

You can bind concrete class in service provider class or use `.env` variables to configure without changing code.

For example, there is specified data storage resolver in `.env` file:
```.env
# available options: sql, file, fake, 
RESOLVER_DATASTORE=sql
```