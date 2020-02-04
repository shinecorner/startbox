# Startbox API

### Installing

```
composer install
php artisan key:generate
php artisan jwt:generate
```

Add the JWT key to the .env file
```
JWT_SECRET=base64:Gk9t... THIS IS AN EXAMPLE ... UoV/DR28Rc8pAf34McsYeJ8=
```

## Running the tests

Run phpunit from your console in the project root
```
vendor/bin/phpunit
```
