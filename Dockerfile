FROM php:8.3.4-fpm

RUN apt update && apt install -y \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo pdo_mysql \
    && docker-php-ext-enable zip pdo_mysql
