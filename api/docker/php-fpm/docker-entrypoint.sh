#!/bin/bash
set -e

echo "[ ****************** ] Starting Endpoint of Application [ ****************** ]"

echo "Back - Starting Endpoint of Application"
if ! [ -d "./vendor" ]; then
    echo " Install depedences whit composer..."
    composer install --ignore-platform-reqs --verbose
#    echo "DB Migration"
#    php artisan migrate:refresh --seed
fi
exec "$@"

set -- php-fpm

exec "$@"
