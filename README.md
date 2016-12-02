# Symfony 2.8 - Exercise 2 - Create a simple service


## Summary

Create a service and use dependency injection to register it


## Goals

Your task is to create, a service accessed by service name "manager.employee" using dependency injection.

When called function `getAll` of this service it should return array of employees listed below:
```
[
  [
  'id' => 1,
  'name' => 'Martin Fowler',
  'bio' => 'A British software developer, author and international public speaker on software development, specializing in object-oriented analysis and design, UML, patterns, and agile software development methodologies, including extreme programming'],
  [
  'id' => 2,
  'name' => 'Kent Beck',
  'bio' => 'An American software engineer and the creator of extreme programming, a software development methodology which eschews rigid formal specification for a collaborative and iterative design process'],
  [
  'id' => 3,
  'name' => 'Robert Cecil Martin',
  'bio' => 'An American software engineer and author. He is a co-author of the Agile Manifesto. He now runs a consulting firm called Clean Code'
  ]
]
```

Expected result of `php app/composer test-dox` for completed exercise is listed below:
```
AppBundle\Tests\Controller\EmployeeManager
 [x] Should exists
 [x] Should has method get all
 [x] When called get all it should return employees array
```


## Hints

Most of changes should lay in `src` dir. You can also modify templates in `app/Resources/views`. If needed You can also modify config and other files in `app` dir.

If You want to see what goals You have passed You should run: `php app/composer test-dox`. Each scenario with **[x]** has passed and those with **[ ]** has to be done.

More info about errors during tests You can get running tests with command: `php app/composer test`

This task is concerned as done when all tests are passing and when code-sniffer and mess-detector do not return errors nor warnings (ignore info about "Remaining deprecation notices" during test).

Remember to commit changes before You change branch.

Remember to install dependencies if You change branch.

### Helpful links

Please remember to read documentation for Symfony 2.8 because it can differ in newer/older versions.

* [Symfony documentation](https://symfony.com/doc/2.8/page_creation.html)

## Requirements

 * You must have installed **PHP 5** with **pdo_mysql** and **json** extensions (result of `php -m` should include pdo_mysql and json). On Debian based (Debian/Ubuntu/Mint) Linux You can install it using `sudo apt-get install php5-mysql php5-json`
 * In some cases it may be required to install **xml** extension for php (`sudo apt-get install php-xml`). Especially if you see **Attempt to load class "DOMDocument" from global namespace** 
 
## Setup

### To install dependencies

    php app/composer install

### Run tests

    php app/composer test

### Run tests as documentation

    php app/composer test-dox
    
### Run static analytics mess detector

    php app/composer mess-detector
    
### Run static analytics code sniffer

    php app/composer code-sniffer


## Run php server

    php app/console server:run
    
**Now You can access website via http://127.0.0.1:8000**

Good luck!
