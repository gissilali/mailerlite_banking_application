# Banking Application

This is how to set up this app

## Installation

Clone the repo locally:

```sh
git clone https://github.com/gissilali/mailerlite_banking_application.git mailerlite_banking_application
```

The frontend nuxt app is located in ``mailerlite_banking_application/web``
 
The backend api is located in ``mailerlite_banking_application/api``

Install PHP dependencies:

```sh
cd mailerlite_banking_application/api
composer install
```

Install NPM dependencies:

```sh
cd mailerlite_banking_application/web
yarn install
```

Build assets on the frontend nuxt app:

```sh
yarn run dev
```

Setup configuration on the backend api:

```sh
cp .env.example .env
```

Generate application key on the backend ap:

```sh
php artisan key:generate
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly.

```sh
touch mailerlite_banking_application/api/database/database.sqlite
```

Run database migrations:

```sh
cd mailerlite_banking_application/api
php artisan migrate
```

Run database seeder:

```sh
cd mailerlite_banking_application/api
php artisan db:seed
```

Run the dev server (the output will give the address): 

```sh
cd mailerlite_banking_application/api/
php artisan serve
```

copy the address above and update the ```.env```  file for the frontend nuxt app accordingly
```
    APP_URL=http://localhost:8000
```