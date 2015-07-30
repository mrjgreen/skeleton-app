# A simple, framework agnostic skeleton app

A simple PHP framework agnostic skeleton application, with routing, controllers and views


##Installation

~~~
git clone git@github.com:mrjgreen/skeleton-app.git

cd skeleton-app

composer install

./task serve
~~~

Now you can open your web browser at http://localhost:8080


##Features

 * Dependency injection (on controllers too) via Provider pattern and `League\Container`
 * Fast request routing with `Phroute`
 * Simple configuration with PHP array (could combine with dotenv for environment based config)
 * Fully testable controllers and routes via `phpunit`
 * Templating with `Twig`
 * Command line tool built in ./task in base directory for `symfony/console` commands
 * Built in web server command `./task serve` in base directory

Its a work in progress but definitely useable. I'll continue to push to this repo and I aim to push another branch with a full web app example, including login, registration, authentication and a simple admin area.
