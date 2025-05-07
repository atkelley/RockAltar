FROM php:8.2-apache

# Install MySQL driver for PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy app code
COPY . /var/www/html/

# Optional: Enable mod_rewrite or other modules
RUN a2enmod rewrite