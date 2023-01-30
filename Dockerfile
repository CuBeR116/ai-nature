FROM --platform=linux/amd64 linux/amd64

FROM php:8.1-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev libpq-dev libmagickwand-dev imagemagick \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && pecl install imagick \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip


RUN apt-get install -y libbz2-dev \
    && docker-php-ext-install bz2 \
    && docker-php-ext-enable bz2

RUN echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini


WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash

#CMD bash -c "composer install"

RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
