FROM amvid/php-rr-base:8.3.9-2024.1.5

WORKDIR /var/www/geo-service

COPY composer.* .

COPY . .

RUN composer install

CMD ["sleep", "30"]
