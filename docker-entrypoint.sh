#!/bin/sh
set -e

# Ensure APP_KEY exists
if [ -z "$APP_KEY" ]; then
    echo "==> APP_KEY not provided. Generating application key..."
    export APP_KEY=$(php artisan key:generate --show)
fi

# Ensure sqlite database file exists if sqlite is used or if no external database is configured
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DATABASE_URL" -a -z "$DB_URL" ]; then
    touch /var/www/html/database/database.sqlite
fi

# Link storage
php artisan storage:link --force || true

# Run database migrations
echo "==> Running migrations..."
php artisan migrate --force || true

# Cache configurations
echo "==> Optimizing configuration and routes..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Ensure permissions for Apache www-data user
chown -R www-data:www-data storage bootstrap/cache database

# Execute Apache in foreground
exec apache2-foreground
