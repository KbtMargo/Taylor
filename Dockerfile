# Runtime: PHP-FPM (без змішаних стейджів CLI/Alpine)
# FROM php:8.3-fpm

# # Встановлюємо залежності та розширення PHP для MySQL
# RUN apt-get update \
#  && apt-get install -y --no-install-recommends \
#       libzip-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev git unzip curl \
#  && docker-php-ext-configure gd --with-jpeg \
#  && docker-php-ext-install -j$(nproc) pdo_mysql mysqli gd zip opcache \
#  && rm -rf /var/lib/apt/lists/*

# # (опційно) Redis — вимкнено, бо у compose поки немає сервісу redis
# # RUN pecl install redis && docker-php-ext-enable redis

# WORKDIR /var/www

FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    build-base \
    autoconf

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip

RUN pecl install redis
RUN docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction --no-progress

RUN chown -R www-data:www-data /var/www

EXPOSE 9000

CMD ["php-fpm"]
