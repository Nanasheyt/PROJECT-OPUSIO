#!/bin/sh
set -e
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

php artisan config:clear
php artisan migrate --force      # creates the tables in Supabase on every deploy (safe to re-run)
exec apache2-foreground
