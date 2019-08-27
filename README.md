# backendTest

I did this test as a laravel project. See here: https://laravel.com/docs/5.8 if installation is an issue. 

The only difficulty maybe connecting with the DB. Settings are in the .env file in the project directory. 
The pertainent lines are the following, shown as they are currently set up:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=currencyConverter
DB_USERNAME=currency
DB_PASSWORD=converter

The migration for the tables is set up in /database/migrations. Running php artisan migrate will set up the tables.

So, running the application should just be a matter of running
> php artisan migrate
and
> php artisan serve
