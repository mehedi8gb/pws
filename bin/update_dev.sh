#!/bin/bash
composer install
php artisan config:clear
until php artisan migrate --seed --force
do
  echo "Migration failed. Trying again..."
done

php artisan optimize:clear
php artisan optimize
chown -R www-data:www-data /app
