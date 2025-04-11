FROM amvid/php-rr-base:8.3.19-2024.3.4

WORKDIR /var/www/geo-service

COPY . .

EXPOSE 8080/tcp

ENTRYPOINT ["sh", ".docker/php/entrypoint.sh"]
