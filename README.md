Simple Application for candidate testing ThinkIT
========================================

 ## ENVIRONMENT:

- composer install
- create .env file, copy from .env.example an paste into .env
- setup database into .env

- DB_CONNECTION=pgsql
- DB_HOST=127.0.0.1
- DB_PORT=5432
- DB_DATABASE=
- DB_USERNAME=root
- DB_PASSWORD=

- docker compose up
- php artisan migrate:fresh --seed
- php artisan serve

# Routes
- php artisan r:l




