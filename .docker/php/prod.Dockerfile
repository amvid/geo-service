FROM dunglas/frankenphp:1.11.3-php8.3.30-alpine

RUN install-php-extensions pdo_mysql intl @composer

WORKDIR /var/www/geo-service

COPY .docker/php/config/php.ini /usr/local/etc/php/conf.d/php.ini
COPY frankenphp/Caddyfile /etc/caddy/Caddyfile

COPY . .

ENV APP_ENV=prod
ENV APP_RUNTIME=Runtime\FrankenPhpSymfony\Runtime

RUN composer install --optimize-autoloader --no-dev --prefer-dist --no-scripts

RUN php -d memory_limit=-1 bin/console cache:clear --no-warmup

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
