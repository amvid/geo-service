FROM dunglas/frankenphp:1.11.3-php8.3.30-alpine

RUN install-php-extensions pdo_mysql intl @composer

WORKDIR /var/www/geo-service

COPY composer.* .

COPY . .

RUN composer install

CMD ["sleep", "30"]
