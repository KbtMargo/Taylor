# ===== 1) BUILD: Composer + Node + Vite =====
FROM php:8.3-cli AS build

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_MEMORY_LIMIT=-1

RUN apt-get update \
 && apt-get install -y git unzip curl gnupg \
 && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
 && apt-get install -y nodejs \
 && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Composer deps без скриптів (artisan ще не скопійований)
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --no-scripts

# Node deps
COPY package.json package-lock.json* ./
RUN if [ -f package-lock.json ]; then npm ci; else npm i --no-audit --no-fund; fi

# Код проєкту
COPY . .

# Composer deps зі скриптами (artisan вже є)
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Білд фронту (laravel-vite-plugin -> public/build)
RUN npm run build

# ===== 2) RUNTIME: мінімальний PHP runtime =====
FROM php:8.3-cli

RUN apt-get update \
 && docker-php-ext-install pdo pdo_mysql

WORKDIR /app
COPY --from=build /app /app

# Права + кеші (без route:cache, якщо є closures)
RUN mkdir -p storage/framework/{cache,sessions,views} \
 && chown -R www-data:www-data storage bootstrap/cache || true \
 && chmod -R 775 storage bootstrap/cache || true \
 && php artisan config:cache || true \
 && php artisan view:cache || true

ENV APP_ENV=production \
    APP_DEBUG=false \
    PORT=10000

EXPOSE 10000
CMD php -S 0.0.0.0:${PORT} -t public server.php
