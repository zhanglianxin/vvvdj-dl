FROM php:7.3-alpine
RUN apk update && apk add chromium-chromedriver zlib-dev libzip-dev && docker-php-ext-install zip
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install
ADD . /data
WORKDIR /data
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/data/public"]
EXPOSE 8080
