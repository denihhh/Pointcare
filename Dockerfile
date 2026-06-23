# --- Stage 1: Build PHP Dependencies ---
FROM composer:latest AS composer-builder
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-req=php

# --- Stage 2: Build Frontend Assets ---
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY . .
# Copy vendor folder from Stage 1 so Vite can resolve alpine-livewire imports
COPY --from=composer-builder /app/vendor ./vendor
RUN npm install && npm run build

# --- Stage 3: Serve PHP-FPM and Nginx ---
FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy composer vendor folder and compiled Vite assets
COPY --from=composer-builder /app/vendor ./vendor
COPY --from=node-builder /app/public/build ./public/build

# Configure image environment variables
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Configure Laravel production defaults
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# Setup permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["/start.sh"]
