#!/bin/sh
set -e

composer install && cp .env.example .env \
    && sed -i "s|CHROME_DRIVER=.*|CHROME_DRIVER=`which chromedriver`|" .env
php artisan vvvdj:dl $URL

exec "$@"
