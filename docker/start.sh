#!/bin/sh
set -e

# Railway can start Apache with more than one MPM enabled, which crash-loops the
# deploy ("AH00534: More than one MPM loaded"). Force prefork-only on every start.
sh "$(dirname "$0")/fix-mpm.sh"

PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

php artisan config:clear
php artisan migrate --force      # creates the tables in Supabase on every deploy (safe to re-run)

# log which MPM Apache really loads (if the config is still broken, the error shows up here)
apache2ctl -M 2>&1 | grep -i mpm || true

exec apache2-foreground
