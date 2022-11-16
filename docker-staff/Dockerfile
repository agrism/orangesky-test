FROM ubuntu:22.04

ENV DEBIAN_FRONTEND noninteractive
ENV COMPOSER_INSTALL=false
ENV RUN_MIGRATION=false
ENV RUN_PHP_FPM=false
ENV RUN_NPM=false
ENV RUN_NGINX=false
ENV RUN_MYSQL=false
ENV APP_LOG_DIR="/var/log/app"

ENV MYSQL_DATABASE=""
ENV MYSQL_USER_NAME=""
ENV MYSQL_USER_PASSWORD=""
ENV MYSQL_ROOT_PASSWORD=""

WORKDIR /var/www

# Setup server timezone
RUN ln -snf /usr/share/zoneinfo/UTC /etc/localtime && echo UTC > /etc/timezone

# Install system dependencies
RUN apt-get update --fix-missing \
    && apt-get install --no-install-recommends -y \
    vim \
    mysql-server \
    nginx \
    ufw \
    wget \
    curl \
    apt-transport-https \
    software-properties-common \
    dirmngr \
    lsb-release \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    gnupg \
    gosu \
    ca-certificates \
    zip \
    unzip \
    git \
    sqlite3 \
    libcap2-bin \
    python3 \
    mysql-client \
    zsh \
    build-essential \
    bash

RUN curl -fsSL https://deb.nodesource.com/setup_16.x |  bash -
RUN apt-get install -y nodejs
RUN apt-get -y autoremove
RUN apt-get -y clean

# Add Ondřej Surý repository for php
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update

RUN apt-get install --no-install-recommends -y \
    php8.1 \
    php8.1-fpm \
    php8.1-cli \
    php8.1-dev \
    php8.1-sqlite3 \
    php8.1-gd \
    php8.1-curl \
    php8.1-memcached \
    php8.1-imap \
    php8.1-mysql \
    php8.1-mbstring \
    php8.1-xml \
    php8.1-zip \
    php8.1-bcmath \
    php8.1-soap \
    php8.1-intl \
    php8.1-readline \
    php8.1-msgpack \
    php8.1-igbinary \
    php8.1-ldap \
    php8.1-redis

# Clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
# Add bootstrap file and subscripts
COPY bootstrap.bash /usr/local/bin/bootstrap.bash
RUN chmod +x /usr/local/bin/bootstrap.bash

# Add composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

ENTRYPOINT ["/usr/local/bin/bootstrap.bash"]

# Default healthcheck
HEALTHCHECK --interval=15s --timeout=5s --start-period=120s --retries=5 \
  CMD pgrep php-fpm || exit 1

##############################################
