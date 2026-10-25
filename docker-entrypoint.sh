#!/bin/sh
set -e

# Link storage
php artisan storage:link --force 2>/dev/null || true

# Run database migrations
php artisan migrate --force 2>/dev/null || true

# Cache configurations
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Execute Apache in foreground
exec apache2-foreground
