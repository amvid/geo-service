FROM php:8.2-fpm-alpine

RUN apk --no-cache add git unzip zip icu-dev libzip-dev $PHPIZE_DEPS

RUN docker-php-ext-install pdo pdo_mysql zip

RUN docker-php-ext-configure intl && docker-php-ext-install intl

WORKDIR /var/www/geo-service

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install