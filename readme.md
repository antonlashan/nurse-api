# Lumen PHP Framework

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Setup app

1. Clone repo
git clone https://github.com/antonlashan/nurse-backend.git
2. Installing dependencies
```
php composer.phar install
```
3. Get a copy of a `.env.production` and rename it as `.env`
Change credentials of DB
4. Run db migrations
`php artisan migrate:refresh --seed`

## Generate api doc
`php artisan apidoc:generate`
after that can be visible in `/public/docs`