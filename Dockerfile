FROM php:7.3-alpine
ADD . /data
WORKDIR /data
RUN apk update && apk add --no-cache chromium chromium-chromedriver zlib-dev libzip-dev \
    composer && docker-php-ext-install zip \
    && export COMPOSER_ALLOW_SUPERUSER=1; \
        CHROME_BIN=/usr/bin/chromium-browser; \
        CHROME_PATH=/usr/lib/chromium/; URL= \
    && chmod +x entrypoint.sh
ENTRYPOINT ["./entrypoint.sh"]
