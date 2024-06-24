# Use the official PHP image with Apache
FROM php:8.3-apache

# Install necessary extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Set the working directory
WORKDIR /var/www/html

# Copy the PHP application files to the Apache web root
COPY . /var/www/html/

# Copy the start script into the container
COPY start.sh /usr/local/bin/start.sh

# Give execution permission to the start script
RUN chmod +x /usr/local/bin/start.sh

# Expose port 8000
EXPOSE 8000

# Command to run the start script
CMD ["sh", "/usr/local/bin/start.sh"]