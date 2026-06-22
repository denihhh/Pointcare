FROM serversideup/php:8.3-fpm-nginx

# Switch to root to install node and configure migration runner
USER root

# Install nodejs and npm
RUN apk add --no-cache nodejs npm

# Create a startup script hook to run migrations automatically
RUN mkdir -p /etc/entrypoint.d && \
    echo "php artisan migrate --force" > /etc/entrypoint.d/99-migrate.sh && \
    chmod +x /etc/entrypoint.d/99-migrate.sh

WORKDIR /var/www/html

# Copy application files and set ownership to webuser
COPY --chown=webuser:webuser . .

# Switch back to webuser for installing dependencies
USER webuser

# Install composer packages and compile Vite assets
RUN composer install --no-dev --optimize-autoloader --no-interaction && \
    npm install && \
    npm run build
