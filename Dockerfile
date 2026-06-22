FROM serversideup/php:8.3-fpm-nginx

# Switch to root to install node and configure migration runner
USER root

# Install nodejs and npm (using apt-get since base image is Ubuntu/Debian)
RUN apt-get update && \
    apt-get install -y --no-install-recommends nodejs npm && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Create a startup script hook to run migrations automatically
RUN mkdir -p /etc/entrypoint.d && \
    echo "php artisan migrate --force" > /etc/entrypoint.d/99-migrate.sh && \
    chmod +x /etc/entrypoint.d/99-migrate.sh

WORKDIR /var/www/html

# Copy application files and set ownership to www-data
COPY --chown=www-data:www-data . .

# Switch back to www-data for installing dependencies
USER www-data

# Install composer packages and compile Vite assets
RUN composer install --no-dev --optimize-autoloader --no-interaction && \
    npm install && \
    npm run build
