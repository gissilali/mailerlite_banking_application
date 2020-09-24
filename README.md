# Banking Application

This is how to set up this app

## Installation

Clone the repo locally:

```sh
git clone https://github.com/gissilali/mailerlite_banking_application.git mailerlite_banking_application
```

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

Build assets:

```sh
yarn run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly.

```sh
touch database/database.sqlite
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```
