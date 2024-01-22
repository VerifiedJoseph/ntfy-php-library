FROM composer:2.6.6 AS composer
FROM php:8.1.27-alpine3.18

COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install packages
RUN apk add --no-cache git
