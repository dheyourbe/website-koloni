# 1. Base Image: PHP 8.3 dengan Apache
FROM php:8.3-apache

# 2. Install System Dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# 3. Install PHP Extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql zip intl

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set working directory
WORKDIR /var/www/html

# 6. Copy project files
COPY . .

# 7. Install PHP dependencies (tanpa dev, optimize autoloader)
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

# 8. Build frontend assets (Vite)
RUN npm install && npm run build

# 9. Set permissions untuk Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# 10. Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# 11. Set DocumentRoot ke public/
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# 12. Gunakan port Railway ($PORT) dinamis
EXPOSE 8080
CMD ["bash", "-c", "sed -i 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf && apache2-foreground"]
