# Runtime: PHP-FPM (без змішаних стейджів CLI/Alpine)
FROM php:8.3-fpm

# Встановлюємо залежності та розширення PHP для MySQL
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      libzip-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev git unzip curl \
 && docker-php-ext-configure gd --with-jpeg \
 && docker-php-ext-install -j$(nproc) pdo_mysql mysqli gd zip opcache \
 && rm -rf /var/lib/apt/lists/*

# (опційно) Redis — вимкнено, бо у compose поки немає сервісу redis
# RUN pecl install redis && docker-php-ext-enable redis

WORKDIR /var/www

# Нічого не копіюємо під час білду — у дев-режимі працюємо через volume (.:/var/www)
# Важливо: artisan, composer, node — запускаєш на хості або окремим build-контейнером, якщо треба
