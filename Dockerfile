# 1. Base Image
FROM php:8.3-apache

# 2. System dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# 3. PHP extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo_mysql zip intl

# 4. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Working directory
WORKDIR /var/www/html

# 6. Copy project files
COPY . .

# 7. Composer dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# 8. Laravel optimizations
RUN php artisan key:generate --force || true
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# 9. Node build
RUN apt-get update && apt-get install -y nodejs npm && rm -rf /var/lib/apt/lists/*
RUN npm install
RUN npm run build

# 10. Permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# 11. Enable mod_rewrite
RUN a2enmod rewrite

# 12. Change DocumentRoot to /public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# 13. Set port for Railway
ENV PORT=8080
RUN sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
RUN sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf
EXPOSE ${PORT}

# 14. Start Apache
CMD ["apache2-foreground"]
