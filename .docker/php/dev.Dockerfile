FROM amvid/php-rr-base:8.3.9-2024.1.5

WORKDIR /var/www/geo-service

COPY . .

EXPOSE 8080/tcp

ENTRYPOINT ["sh", ".docker/php/entrypoint.sh"]
