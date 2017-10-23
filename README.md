# Symfony 2.8 - Exercise 4 - Simple CRUD


## Summary

The expected result of this task is an application which allows users to create/read/update/delete row in the table.

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

1. Create `Employee` entity in `AppBundle/Entity/Employee.php` with proper `namespace`. The entity should contain properties listed below with setters and getters for each one.

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
  
2. Create pages to display the list of employees:
  * it should be accessed via GET on "/employee" route with name "employee_index"
  * you can use "employee/index.html.twig" template for this, it does not require modifications
  * you should pass the list of all employees to template to be accessed via "employees" name inside view
  
3. Create `EmployeeType` form that:
  * should display all properties of employee as the form inputs
  * should require all properties without bio 
  * should have name input that accepts text of max length 64
  * should have surname input that accepts text of max length 64
  * should have email input that accepts email address of max length 254
  * should have daysInOffice input that accepts integer with min value = 2 and max value = 5
  * should have bio textarea that accepts text of max length 400
  * should have save button with label `Save` to submit the form
   
4. Create a page to display the  `EmployeeType` form to create a new employee entry, which:
  * should be accessed via GET and POST on "/employee/new" route with the name "employee_new"
  * you should use "employee/edit.html.twig" template for this, because it does not require modifications
  * you should pass the form to template to be accessed via "form" name
  * if the form has been submitted then data should be validated using form `isValid` and if it is valid it should save the employee and redirect you to "employee_index" 

5. Create a page to display the  `EmployeeType` form to edit an employee entry:
  * it should be accessed via GET and POST on "/employee/{employeeId}/edit" route with the name "employee_edit"
  * you should use "employee/edit.html.twig" template for doing it, as it does not require modifications
  * you should pass the form to template to be accessed via "form" name
  * if the employee with a given `employeeId` does not exist, it should return `404`
  
6. Create a page to delete the employee and to redirect you to employees' list:
  * it should be accessed via GET "/employee/{employeeId}/delete" route with the name "employee_delete"
  * if `employeeId` has not been given, it should return `404` 
  * if the employee with a given `employeeId` does not exist, it should return `404`
  * if such an employee exists, it should delete them and redirect you to "employee_index"

The expected results of `php app/composer test-dox` for the completed exercise are listed below:
```
AppBundle\Tests\Controller\EmployeeControllerActionEditId1
 [x] Should contain the form
 [x] The form should contain the employee's name of type text being required with max length that equals 64
 [x] The form should contain the employee's surname of type text being required with max length that equals 64
 [x] The form should contain the employee's email address of type email being required with max length that equals 254
 [x] The form should contain the employee's bio being not required text area with max length that equals 400
 [x] The form should contain the employee's days in office being required number with min that equals 2 and max that equals 5
 [x] Should contain the index button with the proper link
 [x] The form should contain the anti csrf token
 [x] The form should contain the save button

AppBundle\Tests\Controller\EmployeeControllerActionEditId3
 [x] Should contain the form
 [x] The form should contain the employee's name of type text being required with max length that equals 64
 [x] The form should contain the employee's surname of type text being required with max length that equals 64
 [x] The form should contain the employee's email address of type email being required with max length that equals 254
 [x] The form should contain the employee's bio being not required text area with max length that equals 400
 [x] The Form should contain the employee's days in office being required number with min that equals 2 and max that equals 5
 [x] Should contain the index button with the proper link
 [x] The form should contain the anti csrf token
 [x] The form should contain the save button

AppBundle\Tests\Controller\EmployeeWebTestCaseActionIndex
 [x] Should contain employees' heading
 [x] Should contain add new button with the proper link
 [x] Should contain employees listed
 [x] Each listed employee entry should contain edit and delete buttons with proper links

AppBundle\Tests\Controller\EmployeeControllerActionNew
 [x] Should contain the index button with the proper link
 [x] Should contain the form
 [x] The form should contain the employee's name of type text being required with max length that equals 64
 [x] The form should contain the employee's surname of type text being required with max length that equals 64
 [x] The form should contain the employee's email address of type email being required with max length that equals 254
 [x] The form should contain the employee's bio being not required text area with max length that equals 400
 [x] The form should contain the employee's days in office being required number with min that equals 2 and max that equals 5
 [x] The form should contain the anti csrf token
 [x] The form should contain the save button

AppBundle\Tests\Entity\Employee
 [x] Should not allow to save the employee without the name
 [x] Should not allow to save the employee without the surname
 [x] Should not allow to save the employee without the email address
 [x] Should not allow to save the employee without days in office data
 [x] Should not allow to save the employee with the same email address that exists in db
 [x] Should allow to save the employee without bio
 [x] Should have defined length of each string field and should trim if it is longer

AppBundle\Tests\Feature\CreateEmployee
 [x] Should not save the employee with all fields empty and should display proper info
 [x] Should not save the employee with too short name
 [x] Should not save the employee with too long name
 [x] Should not save the employee with too short surname
 [x] Should not save the employee with too long surname
 [x] Should not save the employee with no valid email address
 [x] Should not save the employee with too long email address
 [x] Should not save the employee with too long bio
 [x] Should not save the employee with invalid type of days in office
 [x] Should not save the employee with too low value of days in office
 [x] Should not save the employee with too high value of days in office
 [x] Should save the employee if proper data is given and should redirect you to employees' list
 [x] Should not require bio

AppBundle\Tests\Feature\DeleteEmployee
 [x] Should return 404 if the employee with the given employee id does not exist
 [x] Should delete certain employee and redirect you to the employees' list

AppBundle\Tests\Feature\UpdateEmployee
 [x] Should save the employee if proper data is given and should redirect you to employees' list
 [x] Should not require bio
 [x] Should not save the employee with all fields empty and should display proper info
 [x] Should not save the employee with too short name
 [x] Should not save the employee with too long name
 [x] Should not save the employee with too short surname
 [x] Should not save the employee with too long surname
 [x] Should not save the employee with no valid email address
 [x] Should not save the employee with too long email address
 [x] Should not save the employee with too long bio
 [x] Should not save the employee with invalid type of days in office
 [x] Should not save the employee with too low value of days in office
 [x] Should not save the employee with too high value of days in office
```


## Hints

Most of the changes should lay in `src` dir. You can also modify templates in `app/Resources/views`. If necessary, you can also modify config and other files in `app` dir.

If you want to see which goals you have achieved you should run: `php app/composer test-dox`. Each scenario with **[x]** has passed and those with **[ ]** still have to be done.

More info about errors during tests you can get by running tests with the command: `php app/composer test`

This task is considered completed when all tests are passing and when the code-sniffer and the mess-detector do not return errors or warnings (ignore the info about "Remaining deprecation notices" while testing).

Remember to commit changes before you change the branch.

Remember to install dependencies if you change the branch.

### Helpful links

Please remember to read documentation for Symfony 2.8 because the newer and the older versions may differ.

* [Symfony documentation](https://symfony.com/doc/2.8/page_creation.html)

## Requirements

 * You must have  **PHP 5** installed with **pdo_mysql** and **json** extensions (the result of `php -m` should include pdo_mysql and json). On Debian based (Debian/Ubuntu/Mint) Linux you can install it using `sudo apt-get install php5-mysql php5-json`
 * In some cases installation of **xml** extension is required for php (`sudo apt-get install php-xml`). Especially if you see **Attempt to load class "DOMDocument" from global namespace** 
 * You must have **MySQL** or **MariaDB** installed or run using docker (see below in Setup/Database configuration)
 
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
    
## Database configuration

You must have database configured to be able to run tests and the website.

If you have docker and docker-compose then all you have to do is to run `docker-compose up -d` and you have db ready to go. ([Install Docker Engine](https://docs.docker.com/engine/installation/), [Install Docker Compose](https://docs.docker.com/compose/install/), remember to add the user to docker group after installing it `sudo usermod -a -G docker YourUserName`)

If you do not have docker then you must install MySQL or MariaDB to have access to port `3306` (default port) and there must be  the database created and named `realskill`, to which the user `realskill` with `realskill` password has access.
```
$ mysql -u root -p
mysql> create database realskill;
mysql> grant usage on *.* to realskill@localhost identified by 'realskill';
mysql> grant all privileges on realskill.* to realskill@localhost ;
```


**Now you can access the website via http://127.0.0.1:8000**

Good luck!
