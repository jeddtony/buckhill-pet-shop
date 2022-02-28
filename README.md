# A Pet Shop API for Buckhill

## Project Overview
This project was written using PHP (Laravel) and documentation was done with Swagger

## Project setup
The project follows the regular Laravel pattern in its setup. 

Run `composer install` to install dependencies. 

This uses passport for authentication. To setup passport run the command `php artisan passport:install`

### Seeding the database
 To run tests simply run the command `php artisan db:seed`

 This will populate the users table with seed data


 ### Running Tests
 To run tests simply run the command `composer test`


## Constraints
This code was developed with small datasets in mind, hence it does not include pagination in its response. When scaling the app, certain database queries made by ORMs should be request by SQL queries to increase speed. 

## Swagger Documentation
You'll need to set the `L5_SWAGGER_CONST_HOST` in the .env file. If this is not set, it defaults to `localhost:8000`. The full URL for the documentation will be found in `localhost:8000/api/documentation/`. 
