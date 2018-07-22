# Booking Application for Doctors

## Introduction
This is a booking application for doctors. It stores the records in a database and users are able add, edit or delete records(username,reason of visit, start time and end time).

### Framework
I started this with Zend Framework 2 and had to add touches of Zend Framework three because of some of ZF2's libraries were migrated and won't work on today's implementation of the Zend Framework Skeleton. So you might see touches of ZF2 and ZF3 in there.

### Database
SQLITE

## Set up instructions:
The easiest way to set this up is through composer. Also we will be using Php's built in webserver as oppose to Appache. and SQLITE for out data storage.

1. Make sure you have composer. Download/update composer - https://getcomposer.org/
2. Clone the project and navigate to the project.
    a. git clone 
    b. cd ./appointment-backend
3. Do a `composer update`. and do a `composer install`.
4. Now because we have a script in our composer.json file. you can just run `composer serve` and it should start up `localhost:8080`. but if that doesn't work you can start the php server manually by running `$ php -S 0.0.0.0:8080 -t public public/index.php`