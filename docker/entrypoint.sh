#!/bin/sh

php bin/console doctrine:migrations:migrate --no-interaction

if [ ! -f config/jwt/private.pem ]; then
    php bin/console lexik:jwt:generate-keypair
fi

php-fpm -D
nginx -g 'daemon off;'
