# Symfony 2.8 - Exercise 1 - Create a page


## Summary

Basic routing and templating


## Goals

Your task is to create a page accessed by path "/about".

You should create a page that has content listed below:
  * "About" in h1 tag
  * "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet assumenda distinctio incidunt inventore nulla omnis sit." in the element with class "story"

The expected result of `php app/composer test-dox` for the completed exercise is listed below:
```
AppBundle\Tests\Controller\AboutController
 [x] Should display the proper heading and story
```


## Hints

Most of the changes should lay in `src` dir. You can also modify templates in `app/Resources/views`. If needed, you can also modify config and other files in `app` dir.

If you want to see which goals you have achieved you should run: `php app/composer test-dox`. Each scenario with **[x]** has passed and those with **[ ]** still have to be done.

More info about errors during tests you can get by running tests with the command: `php app/composer test`

This task is considered completed when all tests are passing and when the code-sniffer and the mess-detector do not return errors or warnings (ignore the info about "Remaining deprecation notices" while testing).

Remember to commit changes before you change the branch.

Remember to install dependencies if you change the branch.

### Helpful links

Please remember to read documentation for Symfony 2.8 because its newer and older versions may differ.

* [Symfony documentation](https://symfony.com/doc/2.8/page_creation.html)

## Requirements

 * You must have **PHP 5** installed with **pdo_mysql** and **json** extensions (the result of `php -m` should include pdo_mysql and json). On Debian based (Debian/Ubuntu/Mint) Linux you can install it using `sudo apt-get install php5-mysql php5-json`
 * In some cases installation of **xml** extension may be required for php (`sudo apt-get install php-xml`). Especially if you see **Attempt to load class "DOMDocument" from global namespace** 
 
## Setup

### To install dependencies

    php app/composer install

### To run tests

    php app/composer test

### To run tests as documentation

    php app/composer test-dox
    
### To run static analytics mess detector

    php app/composer mess-detector
    
### To run static analytics code sniffer

    php app/composer code-sniffer


## To run php server

    php app/console server:run

**Now you can access the website via http://127.0.0.1:8000**

Good luck!
