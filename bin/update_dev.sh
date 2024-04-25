#!/bin/bash
composer install
php artisan optimize:clear
php artisan migrate --seed --force
php artisan optimize
chown -R www-data:www-data /app
