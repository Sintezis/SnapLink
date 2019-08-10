FROM php:7.2-fpm-alpine

# Install dependencies 
RUN apk add --no-cache \
        git \
        autoconf \
        make \
        libxml2-dev \
        imap-dev \
        libmemcached-dev \
        imagemagick-dev \ 
        libmcrypt-dev \
        libpng \
        libpng-dev \
        build-base \
        postgresql-dev \
    && docker-php-ext-install mysqli mbstring pdo pdo_mysql pdo_pgsql tokenizer xml imap gd \
    && pecl channel-update pecl.php.net \
        && pecl install memcached \
        && pecl install imagick \
        && pecl install mcrypt-1.0.1 \
    && docker-php-ext-enable memcached mcrypt imagick imap

# Set working directory
WORKDIR /var/www/application

# Add user for laravel application and give permissions for directory
RUN addgroup -g 1000 -S www \
    && adduser -u 1000 -S www -G www \
    && chown -R www:www /var/www/application

# Change current user to www
USER www
