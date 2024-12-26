# Use the official PHP image with Composer pre-installed
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    php8.2-cli php8.2-fpm php8.2-mbstring php8.2-bcmath php8.2-xml

# Set working directory
WORKDIR /var/www/html

# Copy Composer and application files
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Copy application source code
COPY . .

# Permissions and storage linking
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 9000

CMD ["php-fpm"]
