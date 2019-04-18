FROM php:7.3-cli-alpine
COPY . /data
WORKDIR /data
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN apk update && apk add --no-cache chromium chromium-chromedriver zlib-dev libzip-dev \
    && docker-php-ext-install zip \
    && export COMPOSER_ALLOW_SUPERUSER=1; \
        CHROME_BIN=/usr/bin/chromium-browser; \
        CHROME_PATH=/usr/lib/chromium/; URL= \
    && chmod +x entrypoint.sh
VOLUME /data/storage
ENTRYPOINT ["./entrypoint.sh"]
