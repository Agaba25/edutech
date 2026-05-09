# Optional container deployment (PHP + Apache). Pair with docker-compose for MySQL.
FROM php:8.2-apache

RUN docker-php-ext-install pdo_mysql \
    && a2enmod rewrite

# Allow .htaccess overrides (default image often uses AllowOverride None for /var/www)
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
