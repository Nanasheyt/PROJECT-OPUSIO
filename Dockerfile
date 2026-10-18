FROM php:8.3-apache

RUN apt-get update && apt-get install -y --no-install-recommends libpq-dev libzip-dev unzip git libpng-dev libjpeg-dev libwebp-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install pdo_pgsql pgsql zip gd \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# allow photo uploads up to 5 MB
RUN { echo 'upload_max_filesize=6M'; echo 'post_max_size=64M'; echo 'max_file_uploads=20'; echo 'memory_limit=512M'; } > /usr/local/etc/php/conf.d/uploads.ini

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && sed -ri -e 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts \
    && php artisan package:discover --ansi || true
RUN chown -R www-data:www-data storage bootstrap/cache && chmod +x docker/start.sh

CMD ["docker/start.sh"]
