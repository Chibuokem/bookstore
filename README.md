
## About Bookstore

Bookstore  is a web application build on Laravel  framework with expressive, it gives a user the ability to upload and sell books, with payments handled by [Flutterwave](https://flutterwave.com/ng/)


## Setting up

Pull the application to your server and create your .env file from the .env.example file present, and add the details required there. You also need to have registered an account with [Flutterwave](https://flutterwave.com/ng/) as you need a public key, and secret key detail entered in your .env for payments to work. You can view the laravel documentation, on guide on how to setup Laravel applications [documentation](https://laravel.com/docs).
You need to create cron job for this application to work properly [cron](https://laravel.com/docs/7.x/homestead#configuring-cron-schedules)

To get a user with admin priviledge running on your server,quickly run the seed command on your server [Seeding](https://laravel.com/docs/7.x/seeding#running-seeders) can help. 

You need to also setup your application key [Key](https://laravel.com/docs/7.x/seeding#running-seeders)

## STarting the local server on your local envoiroment

Php artisan serve will get the application up in [Setup doc](https://laravel.com/docs/7.x/installation#installing-laravel).

## Demo
A demo version can be quickly viewed at [Demo](https://bookstore.chibuokemibezim.dev/)