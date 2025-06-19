# Dockerfile
FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite
# Copia un file di configurazione per Apache (opzionale, ma buona pratica)
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN service apache2 restart
