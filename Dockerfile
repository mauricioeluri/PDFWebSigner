FROM php:8.1-apache-bullseye
ADD ./app /var/www/html
EXPOSE 80