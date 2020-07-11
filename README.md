# Misaki (Another osu! Private Server API)

This project is done partially, don't expect something to be worked out of the box for now.

## Requirements

* PHP >= 7.2
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension

## How to Start

1. Clone Repository
2. Install dependencies with `composer install`
3. Copy `.env.example` to `.env`
4. Edit environment variable file `.env`
5. Serve with nginx/apache or run with PHP built in web server `php -S localhost:8000 -t public`
