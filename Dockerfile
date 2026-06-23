# --- Stage 1: Build Frontend Assets ---
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY . .
RUN npm install && npm run build

# --- Stage 2: Serve PHP-FPM and Nginx ---
FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy compiled Vite assets from Node builder stage
COPY --from=node-builder /app/public/build ./public/build

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-req=php

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
