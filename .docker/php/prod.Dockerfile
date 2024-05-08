FROM php:8.3.6-cli-alpine3.18

RUN --mount=type=bind,from=mlocati/php-extension-installer:1.5,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
     install-php-extensions pdo pdo_mysql zip opcache xsl dom exif intl pcntl bcmath sockets && \
     apk add --no-cache git unzip && \
     apk del --no-cache ${PHPIZE_DEPS} ${BUILD_DEPENDS}

WORKDIR /var/www/geo-service

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

ENV APP_ENV=prod

RUN composer install --optimize-autoloader --no-dev --prefer-dist \
     && bin/console assets:install \
     && bin/console cache:clear

COPY --from=ghcr.io/roadrunner-server/roadrunner:2024.1.1 /usr/bin/rr ./bin/rr

EXPOSE 80/tcp

CMD ./bin/rr serve -c .rr.yaml
