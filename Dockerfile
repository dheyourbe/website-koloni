# Gunakan PHP dengan FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Install dependency dasar untuk Laravel dan ekstensi yang dibutuhkan
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql intl zip

# Install Composer (dari image resmi Composer)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Tentukan working directory
WORKDIR /var/www/html

# Copy semua file project ke dalam container
COPY . .

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Expose port
EXPOSE 8000

# Jalankan Laravel menggunakan built-in server
CMD php artisan serve --host=0.0.0.0 --port=8000