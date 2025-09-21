FROM php:8.3-fpm

ARG UID=1000
ARG GID=1000

# Робоча директорія
WORKDIR /var/www

# Інсталятор PHP-розширень
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# Системні залежності (без зайвих рекомендацій)
RUN apt-get update && apt-get install -y --no-install-recommends \
    bash \
    ca-certificates \
    curl \
    git \
    unzip \
    zip \
    locales \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    jpegoptim optipng pngquant gifsicle \
    lua-zlib-dev \
    libmemcached-dev \
    nginx \
    cron \
 && rm -rf /var/lib/apt/lists/*

# PHP-розширення
RUN install-php-extensions mbstring pdo_mysql pdo_pgsql zip exif pcntl gd memcached redis

# Composer
RUN curl -fsSL https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Node.js 18 + npm від NodeSource (без зайвих скриптів з npmjs.com)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
 && apt-get update && apt-get install -y --no-install-recommends nodejs \
 && rm -rf /var/lib/apt/lists/* \
 # Увімкнути corepack (для yarn/pnpm або оновленого npm)
 && corepack enable

# (Опційно) активувати конкретні менеджери
# RUN corepack prepare yarn@stable --activate \
#  && corepack prepare pnpm@latest --activate
#  && corepack prepare npm@latest --activate

# Перевірка версій (залиш — зручно дебажити білд)
RUN node -v && npm -v

# Логи PHP
RUN mkdir -p /var/log/php \
 && touch /var/log/php/errors.log \
 && chmod 777 /var/log/php/errors.log

# Стартовий скрипт
COPY ./start.sh /usr/local/bin/start
RUN chmod u+x /usr/local/bin/start

# Узгодження юзера www-data з твоїми UID/GID
# (щоб файли в томах не створювались від root)
RUN groupmod -o -g $GID www-data \
 && usermod  -o -u $UID www-data \
 && chown -R www-data:www-data /usr/local/bin/start /var/www

USER www-data

CMD ["/usr/local/bin/start"]
