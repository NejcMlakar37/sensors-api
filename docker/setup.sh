#!/bin/bash
set -e

if [ -f /var/www/.env.prod ]; then
    echo "Using .env.prod file"
    cp /var/www/.env.prod /var/www/.env
else
    echo "Warning: .env.prod file not found"
fi

if [ -f /var/www/.env.stage ]; then
    echo "Using .env.stage file"
    cp /var/www/.env.stage /var/www/.env
else
    echo "Warning: .env.stage file not found"
fi

# Generate application key if not exists
php artisan key:generate --force

php artisan storage:link

# Run migrations if needed (be careful with this in production!)
# php artisan migrate --force

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Optimize for production
php artisan optimize

# Fix permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Start supervisord
exec "$@"