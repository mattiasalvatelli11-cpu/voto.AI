FROM php:8.3-apache

# Installa estensioni PHP (anche se non le usiamo più)
RUN docker-php-ext-install pdo_mysql

# Copia tutti i file del progetto
COPY . /var/www/html/

# CREA la cartella uploads + dà i permessi giusti (QUESTO RISOLVE L'ERRORE)
RUN mkdir -p /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html/uploads \
    && chmod -R 755 /var/www/html/uploads

# Abilita rewrite (opzionale)
RUN a2enmod rewrite

EXPOSE 80