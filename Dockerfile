# Use official PHP image with Apache
FROM php:8.2-apache

# Install necessary PHP extensions for MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ensure Apache allows access to the /var/www/html directory
RUN echo "<Directory /var/www/html>" >> /etc/apache2/apache2.conf \
  && echo "    Options Indexes FollowSymLinks" >> /etc/apache2/apache2.conf \
  && echo "    AllowOverride All" >> /etc/apache2/apache2.conf \
  && echo "    Require all granted" >> /etc/apache2/apache2.conf \
  && echo "</Directory>" >> /etc/apache2/apache2.conf

# Enable Apache mod_rewrite (for URL rewriting)
RUN a2enmod rewrite

# Set recommended permissions for the app files
# The 'www-data' user needs to be able to read/write to the app files
RUN chown -R www-data:www-data /var/www/html \
  && chmod -R 755 /var/www/html

# Copy the app code into the Apache document root
COPY . /var/www/html/

# Optionally set Apache's ServerName to avoid a warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port 80 (default HTTP port for Apache)
EXPOSE 80

# Ensure Apache runs in the foreground (important for Docker)
CMD ["apache2-foreground"]
