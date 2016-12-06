# Laravel - Task 3 - OAuth2


## Summary

In order to complete this exercise you will need follow these steps:

1. Create a laravel authentication scaffolding to be able to register and login (You will find how to do it in laravel's documentation). This step is done when:
  * You can see login and register ling on main page
  * When You click on register link You will see register form with "Name", "E-Mail Address", "Password", "Confirm Password" fields and "Register" button
  * When You click on login link You will see login form with "E-Mail Address", "Password" fields, "Remember me" checkbox, "Login" button and "Forgot Your Password?" link
  * When submitted register form with valid data user will be created
  * When submitted register form with existing email it will show error "The email has already been taken."
  * When submitted login form with invalid data You will see "These credentials do not match our records."
  * When submitted login form with valid date it will log You in and redirect to "/home"

2. Create API authentication (You will find how to do it in laravel's documentation). This step is done when:
  * You have installed and configured extension for using OAuth in Laravel (official Laravel extension) 
  * You can create OAuth Clients
  * You can create Personal Access Tokens

You can also generate Vue components and utilize them on "/home" page to be able to create OAuth Clients and Personal Access Tokens in browser.


## Goals

In order to complete this exercise you will need follow these steps:

1. Create a laravel authentication scaffolding to be able to register and login (You will find how to do it in laravel's documentation). This step is done when:
  * You can see login and register ling on main page
  * When You click on register link You will see register form with "Name", "E-Mail Address", "Password", "Confirm Password" fields and "Register" button
  * When You click on login link You will see login form with "E-Mail Address", "Password" fields, "Remember me" checkbox, "Login" button and "Forgot Your Password?" link
  * When submitted register form with valid data user will be created
  * When submitted register form with existing email it will show error "The email has already been taken."
  * When submitted login form with invalid data You will see "These credentials do not match our records."
  * When submitted login form with valid date it will log You in and redirect to "/home"

2. Create API authentication (You will find how to do it in laravel's documentation). This step is done when:
  * You have installed and configured extension for using OAuth in Laravel (official Laravel extension) 
  * You can create OAuth Clients
  * You can create Personal Access Tokens

You can also generate Vue components and utilize them on "/home" page to be able to create OAuth Clients and Personal Access Tokens in browser.

Expected result of `php composer test-dox` for completed exercise is listed below:
```
Authentication
 [x] Should see register link on main page
 [x] Should see login link on main page
 [x] Should see register form on register page
 [x] Should see login form on login page
 [x] Should not register new user if existing email has been submitted
 [x] Should register new user if proper data has been submitted
 [x] Should not login user if bad password has been given
 [x] Should login user if good credentials has been submitted

OAuth2
 [x] Should create o auth client
 [x] Should create personal access token and allow to access api using it
```

## Hints

Most of changes should lay in `app` dir. You can also modify files in `database/migrations`, `routes` and `resources`.

If You want to see what goals You have passed You should run: `php composer test-dox`. Each scenario with **[x]** has passed and those with **[ ]** has to be done.

More info about errors during tests You can get running tests with command: `php composer test`

This task is concerned as done when all tests are passing and when code-sniffer and mess-detector do not return errors nor warnings (ignore info about "Remaining deprecation notices" during test).

Remember to commit changes before You change branch.

Remember to install dependencies if You change branch.

### Helpful links

Please remember to read documentation for Laravel 5.3 because it can differ in newer/older versions.

* [Laravel documentation](https://laravel.com/docs/5.3)

## Requirements

 * You must have installed **PHP 5** with **pdo_mysql** and **json** extensions (result of `php -m` should include pdo_mysql and json). On Debian based (Debian/Ubuntu/Mint) Linux You can install it using `sudo apt-get install php5-mysql php5-json`
 * In some cases it may be required to install **xml** extension for php (`sudo apt-get install php-xml`). Especially if you see **Attempt to load class "DOMDocument" from global namespace** 
 * You must have installed **MySQL** or **MariaDB** or run it using docker (see below in Setup/Database configuration)
 
 
## Setup

### To install dependencies

    php composer install

### Run tests

    php composer test

### Run tests as documentation

    php composer test-dox
    
### Run static analytics mess detector

    php composer mess-detector
    
### Run static analytics code sniffer

    php composer code-sniffer


## Run php server

    php artisan serve
    
    
## Database configuration

You must have configured database to be able to run tests and website.

If you have docker and docker-compose then all You have to do is to run `docker-compose up -d` and You have db ready to go. ([Install Docker Engine](https://docs.docker.com/engine/installation/), [Install Docker Compose](https://docs.docker.com/compose/install/), remember to add user to docker group after installing it `sudo usermod -a -G docker YourUserName`)

If You do not have docker then You must install MySQL or MariaDB to be accessed on port `3306` (default port) and there must be created database named `realskill` to which user `realskill` with password `realskill` has access.
```
$ mysql -u root -p
mysql> create database realskill;
mysql> grant usage on *.* to realskill@localhost identified by 'realskill';
mysql> grant all privileges on realskill.* to realskill@localhost ;
```


**Now You can access website via http://127.0.0.1:8000**

Good luck!
