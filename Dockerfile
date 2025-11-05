# 1. Base image
FROM php:8.3-apache

# 2. Install dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev libzip-dev unzip git curl nodejs npm \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql zip intl \
    && a2enmod rewrite

# 3. Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www/html

# 5. Copy files
COPY . .

# 6. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction || true

# 7. Build frontend (Vite)
RUN npm install && npm run build && rm -rf node_modules

# 8. Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 9. Apache config
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# 10. Dynamic port from Railway
EXPOSE ${PORT}

RUN echo "Container build complete, ready to start Apache"
# 11. Start Apache
CMD bash -c 'if [ -z "$PORT" ]; then PORT=8080; fi \
  && sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf \
  && echo "Apache will listen on port ${PORT}" \
  && apache2-foreground'

