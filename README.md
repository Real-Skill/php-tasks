# Symfony 2.8 - Exercise 3 - Routing with parameters and accessing variables inside view


## Summary

**To complete this task you have to merge the finished branches of task/1-create-page and task/2-create-simple-service to get the starting point.**

    git merge task/1-create-page
    git merge task/2-create-simple-service
    
At this point running `php app/phpunit -c app --testdox` should output as below:

```
AppBundle\Tests\Controller\AboutController
 [x] Should display the proper heading and story
 [ ] Should display the list of employees' names as links

AppBundle\Tests\Controller\EmployeeController
 [x] Should return 404 if no such employee exists
 [ ] Should display the employee's name and bio

AppBundle\Tests\Controller\EmployeeManager
 [x] When called get all it should return employees' array
```

According to the previous tasks, the list of employees is accessible by method `getAll` of service `manager.employee` and the page accessed via GET '/about' contains proper heading to the end story.


## Goals

Your task is to:
 * use the created page in the branch `task/1-create-page`
 * use the service from the solved branch `task/2-create-simple-service`
 * extend the page accessed by path `/about` to contain the list of employees
 * create the page to display the info of a certain employee accessed by path `/employee/{employeeId}`
  
The page accessed by path `/about` should contain:
  * the proper header and the story from `task/1-create-page`
  * "Employees list" as h2
  * a disordered list of employees' names within the element with class `employees`. Each name of an employee should be a link to a dedicated page for a certain employee entry created earlier
 
When you enter the route `/employee/{employeeId}`, a page with the info about a certain employee should be displayed.
 * Their `id` has been given as a route parameter `employeeId`.
 * If the employee with such an id does not exist, it should return 404.
 * Otherwise,  it should display the page that contains:
   * the employee's name as `h1`
   * the employee's bio inside the element with class `bio`

The expected results of `php app/composer test-dox` for the completed exercise are listed below:
```
AppBundle\Tests\Controller\AboutController
 [x] Should display the proper heading and story
 [x] Should display the list of employees' names as links

AppBundle\Tests\Controller\EmployeeController
 [x] Should return 404 if no such employee exists
 [x] Should display the employee's name and bio

AppBundle\Tests\Controller\EmployeeManager
 [x] Should exist
 [x] Should have get all method
 [x] When called, get all should return the employees' array
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

 * You must have  **PHP 5** installed with **pdo_mysql** and **json** extensions (the result of `php -m` should include pdo_mysql and json). On Debian based (Debian/Ubuntu/Mint) Linux you can install it using `sudo apt-get install php5-mysql php5-json`
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
