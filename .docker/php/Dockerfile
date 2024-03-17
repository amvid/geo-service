FROM php:8.3-cli-alpine3.17

RUN --mount=type=bind,from=mlocati/php-extension-installer:1.5,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
     install-php-extensions pdo pdo_mysql zip opcache xsl dom exif intl pcntl bcmath sockets && \
     apk del --no-cache ${PHPIZE_DEPS} ${BUILD_DEPENDS}

WORKDIR /var/www/geo-service

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

ENV APP_ENV=prod

RUN composer install --optimize-autoloader --no-dev --prefer-dist \
     && bin/console assets:install \
     && bin/console cache:clear

COPY --from=ghcr.io/roadrunner-server/roadrunner:2023.3.4 /usr/bin/rr .

EXPOSE 8080/tcp

CMD ./rr serve -c .rr.yaml
