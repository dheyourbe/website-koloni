# 1. Base image: PHP 8.3 + Apache
FROM php:8.3-apache

# 2. Install system dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev libzip-dev unzip git curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql zip intl \
    && a2enmod rewrite

# 3. Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www/html

# 5. Copy project files
COPY . .

# 6. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 7. Build frontend (Vite)
RUN apt-get install -y nodejs npm \
    && npm install \
    && npm run build \
    && rm -rf node_modules

# 8. Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# 9. Apache config
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# 10. Use Railway dynamic port
ENV PORT=8080
EXPOSE 8080

# 11. Start Apache bound to $PORT
CMD ["/bin/bash", "-c", "sed -i \"s/Listen 80/Listen ${PORT}/\" /etc/apache2/ports.conf && apache2ctl -D FOREGROUND"]
