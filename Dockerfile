FROM php:8.2-apache

RUN mkdir -p /uploads && chmod 777 /uploads

COPY . /var/www/html/

RUN chmod 644 /var/www/html/*.php

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf