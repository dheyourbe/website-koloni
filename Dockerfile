# 1. Base Image: PHP 8.3 dengan Apache
FROM php:8.3-apache

# 2. Install System Dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# 3. Install PHP Extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo_mysql zip intl

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set working directory
WORKDIR /var/www/html

# 6. Copy project files
COPY . .

# 7. Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

# 8. Install Node.js & Build assets
RUN apt-get update && apt-get install -y nodejs npm && rm -rf /var/lib/apt/lists/*
RUN npm install
RUN npm run build

# 9. Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# 10. Enable Apache mod_rewrite
RUN a2enmod rewrite

# 11. Change DocumentRoot to /public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# 12. Use dynamic port (for Railway)
ENV PORT=8080
RUN sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
RUN sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf
EXPOSE ${PORT}

# 13. Start Apache
CMD ["apache2-foreground"]
