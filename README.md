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

##Features

 * Dependency injection (on controllers too) via Provider pattern and `League\Container`
 * Fast request routing with `Phroute`
 * Simple configuration with PHP array (could combine with dotenv for environment based config)
 * Fully testable controllers and routes via `phpunit`
 * Templating with `Twig`
 * Command line tool built in ./task in base directory for `symfony/console` commands
 * Built in web server command `./task serve` in base directory
 * DBAL tool and connection manager via `mrjgreen/database`
