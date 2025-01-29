FROM amvid/php-rr-base:8.3.16-2024.3.2

WORKDIR /var/www/geo-service

COPY composer.* .

COPY . .

RUN composer install

CMD ["sleep", "30"]
