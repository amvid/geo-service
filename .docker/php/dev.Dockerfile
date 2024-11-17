FROM amvid/php-rr-base:8.3.13-2024.2.1

WORKDIR /var/www/geo-service

COPY . .

EXPOSE 8080/tcp

ENTRYPOINT ["sh", ".docker/php/entrypoint.sh"]
