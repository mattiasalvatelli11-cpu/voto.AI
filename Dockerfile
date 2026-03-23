FROM php:8.3-apache

# Copia prima tutti i file
COPY . /var/www/html/

# Poi crea uploads + dà i permessi corretti (QUESTO RISOLVE ENTRAMBI GLI ERRORI)
RUN mkdir -p /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN a2enmod rewrite

EXPOSE 80