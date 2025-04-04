# Usa una base image che supporta PHP
FROM php:7.4-apache

# Installa le estensioni necessarie per PHP (incluso mysqli)
RUN docker-php-ext-install mysqli

# Copia i file nella directory /var/www/html di Apache
COPY . /var/www/html/

# Abilita il mod_rewrite di Apache (se necessario)
RUN a2enmod rewrite

# Espone la porta 80 per il server web
EXPOSE 80

# Configura Apache per servirlo
CMD ["apache2-foreground"]
