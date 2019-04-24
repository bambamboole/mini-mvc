# Mini MVC  
[![Build Status](https://travis-ci.org/bambamboole/mini-mvc.svg?branch=master)](https://travis-ci.org/bambamboole/mini-mvc)  

this project is for showing how easy a simple mvc implementation is


## This mini mvc has:
* a composer autoloader
* a simple router with callbacks or class method linking.
* a simple active record implementation
* Twig as template language
* symfony/dotenv for loading environment variables from a .env file


### Installation
* clone repo
* `composer install`
* `cp.env.example .env`
* Fill in database credentials
* Add a table named posts with columns ID, title, content, created. Id should be primary key. created is a string column

### Testing
this project has a simple test setup which needs to be extended.
```
./vendor/bin/phpunit
```
