#!/bin/bash
set -e

# Safety net: make sure only ONE MPM is enabled at runtime
rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.*
a2enmod mpm_prefork >/dev/null 2>&1 || true

# Railway provides $PORT - make Apache listen on it
PORT="${PORT:-8080}"
sed -ri "s/Listen [0-9]+/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Silence "could not determine server name" warning
echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf
a2enconf servername >/dev/null 2>&1 || true

# Laravel bootstrap
php artisan package:discover --ansi || true
php artisan config:clear || true
php artisan migrate --force || echo "Migration failed - continuing"
php artisan storage:link || true

chown -R www-data:www-data storage bootstrap/cache

exec apache2-foreground
