# npm-api

A npm api server made with PHP

## Quick installation

- Clone this repository
- Do a `composer install` to install dependencies
- Create a .env file and add environments variables from .env.example file
- Point your favorite web server (nginx is better) to `index.php` in `public` directory for nginx you can use `nginx-example.conf` file
- And done!

## Usage

Return json result

GET /search?query=mypackage : Search for a package

GET /package/mypackage : Get informations about a package

## Live demo

Endpoint at: `https://npm-api.lefuturiste.fr`
