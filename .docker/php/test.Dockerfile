FROM php:8.2-fpm-alpine

WORKDIR /var/www/geo-service

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install