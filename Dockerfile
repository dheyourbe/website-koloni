# 1. Base Image: PHP 8.3 dengan Apache
FROM php:8.3-apache

# 2. Install System Dependencies
# libicu -> untuk intl
# libzip -> untuk zip
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# 3. Install PHP Extensions (YANG GAGAL TADI)
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo_mysql zip intl

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set working directory (folder web Apache)
WORKDIR /var/www/html

# 6. Copy semua file proyek Anda ke dalam Docker
COPY . .

# 7. Install dependensi Composer
# Kali ini PASTI berhasil karena ekstensi sudah ada
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

# 8. Install Node.js & Build Aset Vite
RUN apt-get update && apt-get install -y nodejs npm \
    && rm -rf /var/lib/apt/lists/*
RUN npm install
RUN npm run build

# 9. Atur Izin (Permission) Folder
RUN chown -R www-data:www-data storage bootstrap/cache

# 10. Aktifkan mod_rewrite Apache (untuk URL cantik Laravel)
RUN a2enmod rewrite

# Server Apache akan otomatis dimulai oleh base image