FROM php:8.4-apache

# Керектүү системалык пакеттерди орнотуу
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Apache жөндөөлөрү (Laravel үчүн AllowOverride күйгүзүү)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Мына ушул сап Apache'ге .htaccess файлын окууга уруксат берет:
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

RUN a2enmod rewrite

# Кодду көчүрүү
WORKDIR /var/www/html
COPY . .

# Composer орнотуу
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Папкаларга уруксат берүү
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# This runs your migrations first, then starts the Apache web server
CMD php artisan migrate --force && apache2-foreground

CMD php artisan migrate --force && php artisan db:seed --force && apache2-foreground