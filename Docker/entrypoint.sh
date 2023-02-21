#!/bin/bash

if [ ! -f "/vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    echo "Creating .env file from $APP_ENV"
    cp .env.example .env
else
    echo ".env file exists"
fi

php artisan key:generate
php artisan migrate
php artisan config:cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan serve --port=$PORT --host=0.0.0.0 --env=.env
exec docker-php-entrypoint "$@"
