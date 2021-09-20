# Sample Api for crypto ticks

This Api is just for testing purpose.

Here is the list of frameworks and language used for this project.

1. Docker
2. PHP 8+
4. Lumen 8+
3. PostgreSQL 13+

## Prerequisites:

Make sure you have installed the docker and docker-compose before moving forward.

## How to:
Please follow the guide to check how to run this project.

1. Clone the project
2. Create a file `src/.env` and copy the content from `src/.env.example` 
3. Build and run the containers with this command `composer up -d`
4. Install the composer dependencies using the command `docker-compose run --rm php composer install`
4. Migrate the database with this command `docker-compose run --rm  php php artisan command:setup-application`
