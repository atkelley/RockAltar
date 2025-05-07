FROM php:8.2-apache

# Start from the official PHP image with Apache
FROM php:7.4-apache

# Install MySQL driver for PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Optional: Install other PHP dependencies or extensions if required
# RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev

# Enable Apache mod_rewrite (for URL rewriting)
RUN a2enmod rewrite

# Set recommended permissions for the app files
RUN chown -R www-data:www-data /var/www/html \
  && chmod -R 755 /var/www/html

# Copy app code into the container
COPY . /var/www/html/

# Optional: Set Apache to run on the appropriate port and server name
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port 80 (default HTTP port)
EXPOSE 80
