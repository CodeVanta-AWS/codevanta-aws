# Use Apache + PHP image as the base
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Install required PHP extensions
RUN docker-php-ext-install mysqli

# Enable Apache Rewrite Module
RUN a2enmod rewrite

# Copy project files to the container
COPY . /var/www/html/

# Set correct file permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 for the web server
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
