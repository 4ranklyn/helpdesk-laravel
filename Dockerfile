# Gunakan base image PHP 8.2 FPM
FROM php:8.2-fpm-alpine

# Setel direktori kerja di dalam kontainer
WORKDIR /var/www


RUN apk add --no-cache \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    mariadb-dev \
    icu-dev \         
    zip \
    unzip \
    jpegoptim \
    pngquant \
    gifsicle \
    vim \
    git \
    supervisor \
    nodejs \        
    npm 
# Instal ekstensi PHP yang dibutuhkan Laravel
# VERSI BARU
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl 

# Instal Composer (Manajer paket PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Hapus cache
RUN rm -rf /var/cache/apk/*

# Salin file proyek dari lokal ke kontainer
COPY . /var/www

# Instal dependensi Composer
RUN composer install --optimize-autoloader --no-dev --no-scripts

# Atur kepemilikan file agar server web bisa menulis ke log dan cache
# 'chown' mungkin perlu disesuaikan tergantung user di image Anda
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Ekspos port 9000 untuk PHP-FPM
EXPOSE 9000

# Perintah default untuk menjalankan PHP-FPM
CMD ["php-fpm"]