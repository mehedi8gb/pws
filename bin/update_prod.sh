#!/bin/bash
composer install
php artisan config:clear
php artisan migrate --seed --force
php artisan optimize:clear
php artisan optimize
chmod -R 755 public_html
