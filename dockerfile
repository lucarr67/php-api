# Usa l'immagine ufficiale di PHP con Apache
FROM php:7.4-apache

# Abilita mod_rewrite per Apache (necessario per alcuni framework PHP)
RUN a2enmod rewrite

# Copia i file del tuo progetto nella cartella /var/www/html di Apache
COPY . /var/www/html/

# Espone la porta 80 (porta HTTP di Apache)
EXPOSE 80
