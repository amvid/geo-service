FROM amvid/php-rr-base:8.3.22-2025.1.2

WORKDIR /var/www/geo-service

COPY . .

ENV APP_ENV=prod

RUN composer install --optimize-autoloader --no-dev --prefer-dist \
     && bin/console assets:install \
     && bin/console cache:clear

EXPOSE 80/tcp

CMD rr serve -c .rr.yaml
