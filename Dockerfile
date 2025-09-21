# ===== 1) BUILD: Composer + Node + Vite =====
FROM php:8.3-cli AS build

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_MEMORY_LIMIT=-1

# Базові утиліти + Node 20 + PHP ext для MySQL
RUN apt-get update \
 && apt-get install -y git unzip curl gnupg \
 && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
 && apt-get install -y nodejs \
 && docker-php-ext-install pdo pdo_mysql

# Composer з офіційного образу
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# 1. Composer deps без скриптів (artisan ще не скопійовано)
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --no-scripts

# 2. Node deps
COPY package.json package-lock.json* ./
RUN if [ -f package-lock.json ]; then npm ci; else npm i --no-audit --no-fund; fi

# 3. Код проєкту
COPY . .

# 4. Composer deps зі скриптами (artisan вже є)
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# 5. Білд фронту (laravel-vite-plugin -> public/build)
RUN npm run build

# ===== 2) RUNTIME: мінімальний PHP runtime =====
FROM php:8.3-cli

# Тільки необхідні PHP-розширення для MySQL
RUN apt-get update \
 && docker-php-ext-install pdo pdo_mysql

WORKDIR /app
COPY --from=build /app /app

# Права на кеш/сторедж (щоб не було 500 на запис)
RUN mkdir -p storage/framework/{cache,sessions,views} \
 && chown -R www-data:www-data storage bootstrap/cache || true \
 && chmod -R 775 storage bootstrap/cache || true \
 && php artisan config:cache || true \
 && php artisan view:cache || true
# За потреби route:cache (лише якщо немає route-closures)
# && php artisan route:cache || true

ENV APP_ENV=production \
    APP_DEBUG=false \
    PORT=8080

EXPOSE 8080
# Простий стартер: віддаємо public/ та слухаємо $PORT від платформи
CMD php -S 0.0.0.0:${PORT} -t public
