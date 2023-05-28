## Installation

Clone this repository and install all dependency first

```sh
composer install
yarn
```

Setup .env by copying .env.example file. Generate the laravel key after that.

```sh
php artisan key:generate

```

Here's the thing. In the .env, you should pay attention to some of the things below

-   APP_ENV = You must set this to production so the attendance system will use a server time. But you can set this to local or development so the attendance system will use an inputted time from the request
-   XENDIT_SECRET_KEY= Copy your xendit api key. This will be use in the rest API
-   XENDIT_CALLBACK_TOKEN= Copy your xendit callback token. This will be use in the rest API
-   QUEUE_CONNECTION= databse, change queue_connection to database so that the queue can work correctly

After you setup the database, run the migration and seeder

```sh
php artisan migrate
php artisan db:seed
```

Run the server and it was ready to use

```sh
php artisan queue:work
php artisan serve
```

## Callback from xendit

To get callback from xendit you can use http tunneling like ngrok

## How To Deploy

After you successfully install it locally, maybe you want to deploy it too. things you should pay attention to when deploying are these.
