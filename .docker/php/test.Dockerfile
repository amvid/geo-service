FROM amvid/php-rr-base:8.3.19-2024.3.4

WORKDIR /var/www/geo-service

COPY composer.* .

COPY . .

RUN composer install

CMD ["sleep", "30"]
