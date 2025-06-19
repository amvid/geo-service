FROM amvid/php-rr-base:8.3.22-2025.1.2

WORKDIR /var/www/geo-service

COPY . .

EXPOSE 8080/tcp

ENTRYPOINT ["sh", ".docker/php/entrypoint.sh"]
