# ===== Build stage: Composer + Node + Vite =====
FROM php:8.3-cli AS build

RUN apt-get update \
 && apt-get install -y git unzip curl gnupg \
 && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
 && apt-get install -y nodejs \
 && docker-php-ext-install pdo pdo_mysql

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# PHP deps
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Node deps
COPY package.json package-lock.json* ./
RUN if [ -f package.json ]; then npm ci; fi

# Код і білд фронту (laravel-vite-plugin -> public/build)
COPY . .
RUN if [ -f package.json ]; then npm run build; fi

# ===== Runtime stage =====
FROM php:8.3-cli

RUN apt-get update && apt-get install -y libpq5 libzip4 \
 && docker-php-ext-install pdo pdo_mysql

WORKDIR /app
COPY --from=build /app /app

ENV APP_ENV=production \
    APP_DEBUG=false \
    PORT=8080

# Віддаємо /public; платформа підставить $PORT
CMD php -S 0.0.0.0:${PORT} -t public
