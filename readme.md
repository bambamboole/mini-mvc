#Mini MVC
this project is for showing how easy an simple mvc implementation is


##This mini mvc has:
* a composer autoloader
* a simple router with callbacks or class method linking.
* a simple active record implementation
* Twig as template language
* symfony/dotenv for loading environment variables from a .env file


###Installation
* clone repo
* `composer install`
* `cp.env.example .env`
* Fill in database credentials
* Add a table named posts with columns ID, title, content, created. Id should be primary key. created is a string column
