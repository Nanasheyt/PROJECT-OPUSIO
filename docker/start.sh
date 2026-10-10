#!/bin/sh
set -e
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Apache can run only ONE MPM, and mod_php needs "prefork". Some hosts (e.g. Railway) start the container with a
# second MPM (event/worker) enabled, which crashes Apache: "AH00534: More than one MPM loaded".
a2dismod -f mpm_event mpm_worker || true
rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.*
a2enmod mpm_prefork || true
apache2ctl -t                    # prints the exact reason in the logs if the Apache config is still invalid

php artisan config:clear
php artisan migrate --force      # creates the tables in Supabase on every deploy (safe to re-run)
exec apache2-foreground
