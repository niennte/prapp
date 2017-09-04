FROM php:7.0-apache

RUN apt-get update \
 && apt-get install -y git zlib1g-dev \
 && apt-get install -y libpq-dev \
 && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
 && docker-php-ext-install zip pdo_pgsql \
 && a2enmod rewrite \
 && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf \
 && chown -R www-data:www-data /var/www \
 && rm -R /var/www/html \
 && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

RUN useradd -ms /bin/bash app

WORKDIR /var/www