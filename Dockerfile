FROM php:8.2-apache

RUN mkdir -p /uploads && chmod 777 /uploads

COPY . /var/www/html/

RUN chmod 644 /var/www/html/*.php