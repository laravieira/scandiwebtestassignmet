FROM serversideup/php:8.3-fpm-apache

ENV DATABASE_HOST 127.0.0.1
ENV DATABASE_NAME sta
ENV DATABASE_USER sta
ENV DATABASE_PASS password
ENV POPULATE populate.json

USER www-data:www-data
WORKDIR /var/www/html
COPY --chown=www-data:www-data . .

RUN composer install --no-dev --no-interaction --no-plugins --no-scripts --prefer-dist
RUN composer dump-autoload