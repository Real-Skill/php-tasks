# Symfony 2.8 - Exercise 4 - Simple CRUD


## Summary

Expected result of this task is an application which allows user to create/read/update/delete row in the table.

Sample employee structure:
```
[
    'id' => 1,
    'name' => 'Martin'
    'surname' => 'Fowler'
    'email' => 'martin.fowler@fake.pl'
    'daysInOffice' => 2,
    'bio' => 'Lorem ipsum dolor sit amet.'
]
```


## Goals

In order to complete this exercise you will need to follow these steps:

1. Create `Employee` entity in `AppBundle/Entity/Employee.php` with proper `namespace`. Entity should contain properties listed below with setters and getters for each one.

  * id - primary key, autoincrement
  * name - type: `string`, length: 64, required, assertions:
    * not blank
    * min length = 3
    * max length = 64
  * surname  - type: `string`, length: 64, required, assertions: 
    * not blank
    * min length = 3
    * max length = 64
  * email  - type: `string`, length: 254, required, unique, assertions:
    * not blank
    * email
    * max length = 254
  * bio  - type: `string`, length: 400, not required, assertions:
    * max length = 400
  * daysInOffice  - type: `smallint`, required, assertions:
    * not blank
    * range(2,5)
    * min range message = "You must be at least {{ limit }} days working in the office."
    * max range message = "You cannot work more than {{ limit }} days in the office."
  
2. Create pages to display list of employees
  * should be accessed via GET on "/employee" route with name "employee_index"
  * use "employee/index.html.twig" template for this, it not requires modifications
  * pass list of all employees to template to be accessed via "employees" name inside view
  
3. Create `EmployeeType` form
  * it should display all properties of employee as form inputs
  * all properties without bio should be required
  * name should be input that accepts text of max length 64
  * surname should be input that accepts text of max length 64
  * email should be input that accepts email of max length 254
  * daysInOffice should be input that accepts integer with min value = 2 and max value = 5
  * bio should be textarea that accepts text of max length 400
  * save button with label `Save` to submit form
   
4. Create page to display form `EmployeeType` to create new employee:
  * should be accessed via GET and POST on "/employee/new" route with name "employee_new"
  * use "employee/edit.html.twig" template for this, it not requires modifications
  * pass form to template to be accessed via "form" name
  * if form has been submitted then data should be validated using form `isValid` and if it is valid it should save employee and redirect to "employee_index" 

5. Create page to display form `EmployeeType` to edit employee:
  * should be accessed via GET and POST on "/employee/{employeeId}/edit" route with name "employee_edit"
  * use "employee/edit.html.twig" template for this, it not requires modifications
  * pass form to template to be accessed via "form" name
  * if employee with given `employeeId` does not exist it should return `404`
  
6. Create page to delete employee and redirect to employees list
  * should be accessed via GET "/employee/{employeeId}/delete" route with name "employee_delete"
  * if `employeeId` has not been given it should return `404` 
  * if employee with given `employeeId` does not exist it should return `404`
  * if such employee exists it should delete him and redirect to "employee_index"

Expected result of `php app/composer test-dox` for completed exercise is listed below:
```
AppBundle\Tests\Controller\EmployeeControllerActionEditId1
 [x] Should contain form
 [x] Form should contain employee name of type text being required with max length equal 64
 [x] Form should contain employee surname of type text being required with max length equal 64
 [x] Form should contain employee email of type email being being required with max length equal 254
 [x] Form should contain employee bio being not required text area with max length equal 400
 [x] Form should contain employee days in office being required number with min equal 2 and max equal 5
 [x] Should contain button index with proper link
 [x] Form should contain anti csrf token
 [x] Form should contain save button

AppBundle\Tests\Controller\EmployeeControllerActionEditId3
 [x] Should contain form
 [x] Form should contain employee name of type text being required with max length equal 64
 [x] Form should contain employee surname of type text being required with max length equal 64
 [x] Form should contain employee email of type email being being required with max length equal 254
 [x] Form should contain employee bio being not required text area with max length equal 400
 [x] Form should contain employee days in office being required number with min equal 2 and max equal 5
 [x] Should contain button index with proper link
 [x] Form should contain anti csrf token
 [x] Form should contain save button

AppBundle\Tests\Controller\EmployeeWebTestCaseActionIndex
 [x] Should contain employees heading
 [x] Should contain add new button with proper link
 [x] Should contain employees listed
 [x] Each listed employee should contain edit and delete buttons with proper links

AppBundle\Tests\Controller\EmployeeControllerActionNew
 [x] Should contain button index with proper link
 [x] Should contain form
 [x] Form should contain employee name of type text being required with max length equal 64
 [x] Form should contain employee surname of type text being required with max length equal 64
 [x] Form should contain employee email of type email being being required with max length equal 254
 [x] Form should contain employee bio being not required text area with max length equal 400
 [x] Form should contain employee days in office being required number with min equal 2 and max equal 5
 [x] Form should contain anti csrf token
 [x] Form should contain save button

AppBundle\Tests\Entity\Employee
 [x] Should not allow to save employee without name
 [x] Should not allow to save employee without surname
 [x] Should not allow to save employee without email
 [x] Should not allow to save employee without days in office
 [x] Should not allow to save employee with same email that exists in db
 [x] Should allow to save employee without bio
 [x] Should have defined length of each string field and trim if is longer

AppBundle\Tests\Feature\CreateEmployee
 [x] Should not save employee with all fields empty and display proper info
 [x] Should not save employee with to short name
 [x] Should not save employee with to long name
 [x] Should not save employee with to short surname
 [x] Should not save employee with to long surname
 [x] Should not save employee with not valid email
 [x] Should not save employee with to long email
 [x] Should not save employee with to long bio
 [x] Should not save employee with invalid type of days in office
 [x] Should not save employee with to low value of days in office
 [x] Should not save employee with to high value of days in office
 [x] Should save employee if proper data is given and redirect to employees list
 [x] Should not require bio

AppBundle\Tests\Feature\DeleteEmployee
 [x] Should return 404 if employee with given employee id not exist
 [x] Should delete certain employee and redirect to employees list

AppBundle\Tests\Feature\UpdateEmployee
 [x] Should save employee if proper data is given and redirect to employees list
 [x] Should not require bio
 [x] Should not save employee with all fields empty and display proper info
 [x] Should not save employee with to short name
 [x] Should not save employee with to long name
 [x] Should not save employee with to short surname
 [x] Should not save employee with to long surname
 [x] Should not save employee with not valid email
 [x] Should not save employee with to long email
 [x] Should not save employee with to long bio
 [x] Should not save employee with invalid type of days in office
 [x] Should not save employee with to low value of days in office
 [x] Should not save employee with to high value of days in office
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
 * You must have installed **MySQL** or **MariaDB** or run it using docker (see below in Setup/Database configuration)
 
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
