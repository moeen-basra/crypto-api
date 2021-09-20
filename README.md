# Sample Api for crypto ticks

This Api is just for testing purpose. 

Demo: https://lumen-crypto-api.herokuapp.com/ 

Here is the list of frameworks and language used for this project.

1. Docker
2. PHP 8+
4. Lumen 8+
3. PostgreSQL 13+

## Prerequisites:

Make sure you have installed the docker and docker-compose before moving forward.

## How to install:

Please follow the guide to check how to run this project.

1. Clone the project
2. Create a file `src/.env` and copy the content from `src/.env.example`
3. Build and run the containers with this command `composer up -d`
4. Install the composer dependencies using the command `docker-compose run --rm php composer install`
4. Migrate the database with this command `docker-compose run --rm  php php artisan command:setup-application`

## How to user:

This api has following four end points

1. Login

   This api has two parameters

   a. email: `required and valid email`

   b. password: `required and min length 8`

   ```
   curl --location --request POST '/login' \
    --header 'Content-Type: application/json' \
    --data-raw '{
    "email": "m.basra@live.com",
    "password": "secret123"
    }'
   ```

2. Register
   
   This api has 4 parameters
   
   a. name: `required`

   b. email: `required and valid email`

   c. password: `required and min length 8`
   
   d. password_confirmation: `same as password`
   ```
   curl --location --request POST '/register' \
    --header 'Content-Type: application/json' \
    --data-raw '{
    "name": "Moeen",
    "email": "m.basra@live.com",
    "password": "secret123",
    "password_confirmation": "secret123"
    }'
   ```
3. Coins
   
   This api has 1 query param
   
   a. sort: `ASC|DESC, default=ASC`
   ```
    curl --location --request GET '/coins?sort=DESC'
    ```

4. Ticker
   
   This route needs 1 param and authorization header

   a. coin_code: `required`

   b. Authorization: 'required'
   

   ```
   curl --location --request GET '/ticker/{coin_code}' \
   --header 'Authorization: Bearer {jwt_token}'
   ```
