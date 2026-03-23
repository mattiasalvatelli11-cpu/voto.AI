FROM php:8.3-apache

RUN docker-php-ext-install pdo_mysql

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html/uploads \
    && chmod -R 755 /var/www/html/uploads

RUN a2enmod rewrite

EXPOSE 80