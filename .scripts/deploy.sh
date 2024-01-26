#!/bin/bash
set -e

echo "Deployment started ..."

# Change to the project directory
# cd /home/radaxnao/public_html/

# Enter maintenance mode or return true
# if already is in maintenance mode
(php artisan down) || true

# Pull the latest version of the app
git pull origin trunk

# Install composer dependencies
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Clear the old cache
php artisan clear-compiled

chmod -R 777 storage bootstrap/cache
# Recreate cache
php artisan optimize

# Compile npm assets
npm run dev

# Copy contents from .env.example
# cp .env.example .env

# Generate new key
php artisan key:generate

# Run database migrations
php artisan migrate --force

# Exit maintenance mode
php artisan up

echo "Deployment finished!"