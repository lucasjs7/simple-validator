FROM php:8.2-apache

# Extensions PHP
RUN apt-get update -y \
    && docker-php-ext-install bcmath

# Build
# docker build --tag simple-validator-dev -f setup\Dev.Dockerfile .