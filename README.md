# Symfony 2.8 - Exercise 3 - Routing with parameters and accessing variables inside view


## Summary

**To solve this exercise you have to merge finished branchs of task/1-create-page and task/2-create-simple-service to get the start point.**

    git merge task/1-create-page
    git merge task/2-create-simple-service
    
At this point running `php app/phpunit -c app --testdox` should output as below:

```
AppBundle\Tests\Controller\AboutController
 [x] Should display proper heading and story
 [ ] Should display list of employees names as links

AppBundle\Tests\Controller\EmployeeController
 [x] Should return 404 if no such employee
 [ ] Should display employee name and bio

AppBundle\Tests\Controller\EmployeeManager
 [x] When called get all it should return employees array
```

According to previous tasks, list of employees is accessible by method `getAll` of service `manager.employee` and page accessed via GET '/about' contains proper heading end story.


## Goals

Your task is to:
 * use created page in branch `task/1-create-page`
 * use service from solved branch `task/2-create-simple-service`
 * extend page accessed by path `/about` to contain list of employees
 * create page to display info of certain employee accessed by path `/employee/{employeeId}`
  
Page accessed by path `/about` should contain:
  * Proper header and story from `task/1-create-page`
  * "Employees list" as h2
  * Unordered list of employees names within element with class `employees`. Each name of employee should be, a link to dedicated page for certain employee created earlier
 
When you enter route `/employee/{employeeId}` page with info about certain employee should be displayed.
 * His `id` has been given as a route parameter `employeeId`.
 * If employee with such id does not exist it should return 404.
 * In other case it should display page that contains:
   * Employee's name as `h1`
   * Employee's bio inside element with class `bio`

Expected result of `php app/composer test-dox` for completed exercise is listed below:
```
AppBundle\Tests\Controller\AboutController
 [x] Should display proper heading and story
 [x] Should display list of employees names as links

AppBundle\Tests\Controller\EmployeeController
 [x] Should return 404 if no such employee
 [x] Should display employee name and bio

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
