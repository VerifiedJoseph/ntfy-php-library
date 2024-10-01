FROM composer:2.7.9 AS composer
FROM php:8.1.28-alpine3.18

RUN apk add --update --no-cache --virtual .build-deps $PHPIZE_DEPS linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps

COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install packages
RUN apk add --no-cache git
