FROM php:8.2

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8000
