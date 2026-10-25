#!/bin/sh
set -e

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
chown -R www-data:www-data storage bootstrap/cache

# Execute Apache in foreground
exec apache2-foreground
