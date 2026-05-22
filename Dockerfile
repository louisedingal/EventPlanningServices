# EventPlanning — production image (nginx + PHP-FPM). Local dev: docker compose (INSTALL_DEV_DEPS=1).
FROM php:8.2-fpm-bookworm

ARG INSTALL_DEV_DEPS=0

RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    curl \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        intl \
        zip \
        opcache \
        gd \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock symfony.lock ./
RUN composer install --no-interaction --prefer-dist --no-scripts --no-autoloader

COPY . .

# Symfony console (composer post-install scripts) requires .env on disk (.env is not in the image context).
RUN cp .env.example .env

# --no-scripts: avoid symfony-cmd post-install (not on PATH when plugins disabled as root).
# Prod cache/assets run in entrypoint.sh instead.
RUN if [ "$INSTALL_DEV_DEPS" = "1" ]; then \
        COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --prefer-dist; \
    else \
        COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --prefer-dist --no-dev --no-scripts; \
    fi \
    && composer dump-autoload --optimize --classmap-authoritative \
    && test -f vendor/autoload_runtime.php

RUN sed -i 's/^APP_ENV=.*/APP_ENV=prod/' .env \
    && sed -i 's/^APP_DEBUG=.*/APP_DEBUG=0/' .env

# Vendor JS for AssetMapper (not committed; required before asset-map:compile)
RUN php bin/console importmap:install --no-interaction \
    && php bin/console asset-map:compile --env=prod --no-debug

RUN mkdir -p var/cache var/log public/uploads/service-packages public/uploads/theme-samples config/jwt \
    && chown -R www-data:www-data var public/uploads config/jwt

COPY docker/nginx-main.conf /etc/nginx/nginx.conf
COPY docker/nginx.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
