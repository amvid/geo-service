FROM amvid/php-rr-base:8.3.13-2024.2.1

WORKDIR /var/www/geo-service

COPY composer.* .

COPY . .

RUN composer install

CMD ["sleep", "30"]
