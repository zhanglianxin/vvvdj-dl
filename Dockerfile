FROM php:7.3-alpine
RUN apk update && apk add chromium-chromedriver zlib-dev libzip-dev composer && docker-php-ext-install zip
ADD . /data
WORKDIR /data
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install && cp .env.example .env && sed -i "s|CHROME_DRIVER=.*|CHROME_DRIVER=`which chromedriver`|" .env
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/data/public"]
EXPOSE 8080
