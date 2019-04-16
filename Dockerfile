FROM php:7.3-alpine
ADD . /data
WORKDIR /data
RUN apk update && apk add chromium-chromedriver zlib-dev libzip-dev && docker-php-ext-install zip
CMD ["composer", "install"]
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/data/public"]
