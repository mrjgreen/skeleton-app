# A simple, framework agnostic skeleton app

A simple PHP framework agnostic skeleton application, with routing, controllers and views


##Installation

Set up the database and add the table from `database.sql`

Add your database user and password to the `app/config.php` file

~~~
git clone git@github.com:mrjgreen/skeleton-app.git

cd skeleton-app

composer install

./task serve
~~~

Now you can open your web browser at http://localhost:8080 or run the tests with `phpunit`
