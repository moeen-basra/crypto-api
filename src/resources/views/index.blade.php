<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crypto Api</title>
</head>
<body>
<div>
    <h1>Sample Api for crypto ticks</h1>
    <p>This Api is just for testing purpose.</p>
    <p>Demo: <a href="https://lumen-crypto-api.herokuapp.com/">https://lumen-crypto-api.herokuapp.com/</a></p>

    <h3>Here is the list of frameworks and language used for this project.</h3>

    <ol>
        <li>Docker</li>
        <li>PHP 8+</li>
        <li>Lumen 8+</li>
        <li>PostgreSQL 13+</li>
    </ol>

    <h4>Prerequisites:</h4>
    <p>Make sure you have installed the docker and docker-compose before moving forward.</p>

    <h4>How to install:</h4>
    <p>Please follow the guide to check how to run this project.</p>
    <OL>
        <li>Clone the project</li>
        <li>Create a file src/.env and copy the content from src/.env.example</li>
        <li>Build and run the containers with this command composer up -d</li>
        <li>Install the composer dependencies using the command docker-compose run --rm php composer install</li>
        <li>Migrate the database with this command docker-compose run --rm php php artisan command:setup-application</li>
    </OL>

    <h4>How to use:</h4>
    <p>This api has following four end points</p>
    <h5>Login</h5>
    <p>This api has two parameters</p>
    <ol>
        <li>email: required and valid email</li>
        <li>password: required and min length 8</li>
    </ol>
    <pre>
        curl --location --request POST '/login' \
            --header 'Content-Type: application/json' \
            --data-raw '{
            "email": "m.basra@live.com",
            "password": "secret123"
            }'
    </pre>

    <h5>Register</h5>
    <p>This api has 4 parameters</p>
    <ol>
        <li>name: required</li>
        <li>email: required and valid email</li>
        <li>password: required and min length 8</li>
        <li>password_confirmation: same as password</li>
    </ol>
    <pre>
        curl --location --request POST '/register' \
            --header 'Content-Type: application/json' \
            --data-raw '{
            "name": "Moeen",
            "email": "m.basra@live.com",
            "password": "secret123",
            "password_confirmation": "secret123"
            }'
    </pre>

    <h5>Coins</h5>
    <p>This api has 1 query param</p>
    <ol>
        <li>sort: ASC|DESC, default=ASC</li>
    </ol>
    <pre>
        curl --location --request GET '/coins?sort=DESC'
    </pre>

    <h5>Ticker</h5>
    <p>This route needs 1 param and authorization header</p>
    <ol>
        <li>coin_code: required</li>
        <li>Authorization: 'required'</li>
    </ol>
    <pre>
        curl --location --request GET '/ticker/{coin_code}' \
            --header 'Authorization: Bearer {jwt_token}'
    </pre>
</div>
</body>
</html>
