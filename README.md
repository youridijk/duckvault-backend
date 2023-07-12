# DuckVault backend
This is the backend for the [DuckVault app](https://github.com/youridijk/duckvault). 
This backend handles all requests that need authentications. All others request are handled by PostgREST.

## Installation
Install composer dependencies
- `composer install`

Start a Redis database and run the backend:
- `php artisan serve`

or with sail:
- `./vendor/bin/sail up -d`
