FROM amvid/php-rr-base:8.3.22-2025.1.2

WORKDIR /var/www/geo-service

COPY composer.* .

COPY . .

RUN composer install

CMD ["sleep", "30"]
