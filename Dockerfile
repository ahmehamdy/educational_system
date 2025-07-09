# المرحلة الأولى: build ملفات Vite
FROM node:18 AS node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# المرحلة الثانية: إعداد Laravel
FROM php:8.2-fpm

# تثبيت متطلبات Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# نسخ المشروع من المرحلة الأولى (اللي فيها build Vite)
COPY --from=node /app /var/www

# تثبيت Laravel
RUN composer install --ignore-platform-reqs --no-interaction --prefer-dist --optimize-autoloader

# صلاحيات للـ storage
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
