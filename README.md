# Symfony 2.8 - Exercise 5 - Simple CRUD on REST


## Summary

The expected result of this task is an application which allows the user to create/read/update/delete row in the table using REST requests.

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

To make working with JSON requests easy we have installed and configured **symfony-json-request-transformer** bundle as follows:
```
A request with JSON content like:
{
  "foo": "bar"
}
will be decoded automatically so it can access the foo property like:

$request->request->get('foo');
```

If you have solved **Symfony 2 - Exercise 4 - Simple CRUD** then you can copy `Employee` entity to this branch and step 1 will be done.
`git checkout task/4-simple-crud -- src/AppBundle/Entity/Employee.php`

In this exercise no form creation is required. If you want to experiment with a ready app you can use, for example, chrome extension called **[Postman](https://chrome.google.com/webstore/detail/postman/fhbjgbiflinjbdggehcddcbncdddomop?utm_source=chrome-ntp-icon)**.

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
  
2. Create an endpoint to retrieve the list of employees that:
  * should be accessed via GET "/api/employee"
  * should return the array of employees as JSON
  
3. Create an endpoint to create a new employee entry, which:
  * should be accessed via POST "/api/employee"
  * should assign the name, surname, email address, bio, daysInOffice from request to `Employee` object
  * should validate if `Employee` is valid after assigning the data
  * if `Employee` is invalid it should return JSON with property success set to false and errors containing array of error messages per each property with **PRECONDITION_FAILED** status code - use specially created for this purpose `violation_list_converter` service to convert errors from `validator` service to array eg:
  ```
  {
    "success": false,
    "errors": {
      "name": "This value should not be blank."
    }
  }
  ```
  * if a unique constraint throws exception it should return JSON response with property success set to false and errors containing info for `email` property that `Such email exists in DB.` with **CONFLICT** status code like below:
  ```
  {
    "success": false,
    "errors": {
      "email": "Such email exists in DB."
    }
  }
  ```
  * if `Employee` is valid it should create it and return JSON response with property `success` set to true and id set to newly created object id like below:
  ```
  {
    "success": true,
    "id": 15
  }
  ```
  
4. Create an endpoint to update the existing employee data, which:
  * should be accessed via PUT "/api/employee/{employeeId}"
  * should assign the name, surname, email address, bio, daysInOffice from request to `Employee` object
  * should validate if `Employee` is valid after assigning the data
  * if `Employee` with given `employeeId` does not exist it should return **NOT_FOUND** status code and JSON with property `success` set to false
  * if `Employee` is invalid it should return JSON with property success set to false and errors containing array of error messages per each property with **PRECONDITION_FAILED** status code - use specially created for this purpose `violation_list_converter` service to convert errors from `validator` service to array eg:
    ```
    {
      "success": false,
      "errors": {
        "name": "This value should not be blank."
      }
    }
    ```
    * if a unique constraint throws exception it should return JSON response with property success set to false and errors containing info for `email` property that `Such email exists in DB.` with **CONFLICT** status code like below:
    ```
    {
      "success": false,
      "errors": {
        "email": "Such email exists in DB."
      }
    }
    ```
    * if `Employee` is valid it should create it and return JSON response with property `success` set to true and id set to the newly created object id like below:
    ```
    {
      "success": true,
      "id": 15
    }
    ```

5. Create an endpoint to delete existing employee entry:
  * it should be accessed via DELETE "/api/employee/{employeeId}"
  * if `Employee` with a given `employeeId` does not exist it should return **NOT_FOUND** status code and JSON with property `success` set to false
  * if `Employee` with a given `employeeId` exists it should delete them and return JSON with property `success` set to true

The expected results of `php app/composer test-dox` for the completed exercise are listed below:
```
AppBundle\Tests\Entity\Employee
 [x] Should not allow to save the employee without a name
 [x] Should not allow to save the employee without a surname
 [x] Should not allow to save the employee without email address
 [x] Should not allow to save the employee without days in office
 [x] Should not allow to save the employee with the same email address that exists in db
 [x] Should allow to save the employee without bio
 [x] Should have defined length of each string field and should trim if it is longer

AppBundle\Tests\Feature\CreateEmployee
 [x] Should return precondition failed with proper errors if empty data is sent
 [x] Should return precondition failed with proper errors if all sent employee properties are empty
 [x] Should return precondition failed with proper errors if the name is too short
 [x] Should return precondition failed with proper errors if the name is too long
 [x] Should return precondition failed with proper errors if the surname is too short
 [x] Should return precondition failed with proper errors if the surname is too long
 [x] Should return precondition failed with proper errors if the email address is invalid
 [x] Should return precondition failed with proper errors if the email address is too long
 [x] Should return precondition failed with proper errors if bio is too long
 [x] Should return precondition failed with proper errors if days in office is invalid
 [x] Should return precondition failed with proper errors if days in office has too low value
 [x] Should return precondition failed with proper errors if days in office has too high value
 [x] Should save the employee if proper data is given and should return its id
 [x] Should not require bio

AppBundle\Tests\Feature\DeleteEmployee
 [x] Should return 404 if the employee does not exist and json with property status set to false
 [x] Should delete certain employee

AppBundle\Tests\Feature\RetrieveEmployee
 [x] Should return the employees' array

AppBundle\Tests\Feature\UpdateEmployee
 [x] Should save the employee if proper data is given and should return its id
 [x] Should not require bio
 [x] Should return precondition failed with proper errors if empty data is sent
 [x] Should return precondition failed with proper errors if all sent employee properties are empty
 [x] Should return precondition failed with proper errors if the name is too short
 [x] Should return precondition failed with proper errors if the name is too long
 [x] Should return precondition failed with proper errors if the surname is too short
 [x] Should return precondition failed with proper errors if the surname is too long
 [x] Should return precondition failed with proper errors if the email address is invalid
 [x] Should return precondition failed with proper errors if the email address is too long
 [x] Should return precondition failed with proper errors if bio is too long
 [x] Should return precondition failed with proper errors if days in office is invalid
 [x] Should return precondition failed with proper errors if days in office has too low value
 [x] Should return precondition failed with proper errors if days in office has too high value
```


## Hints

Most of the changes should lay in `src` dir. You can also modify templates in `app/Resources/views`. If needed, you can also modify config and other files in `app` dir.

If you want to see which goals you have achieved you should run: `php app/composer test-dox`. Each scenario with **[x]** has passed and those with **[ ]** still have to be done.

More info about errors during tests you can get by running tests with the command: `php app/composer test`

This task is considered completed when all the tests are passing and when the code-sniffer and the mess-detector do not return errors or warnings (ignore the info about "Remaining deprecation notices" while testing).

Remember to commit changes before you change the branch.

Remember to install dependencies if you change the branch.

### Helpful links

Please remember to read the documentation for Symfony 2.8 because the new version and the older ones can diffe.

* [Symfony documentation](https://symfony.com/doc/2.8/page_creation.html)

## Requirements

 * You must have  **PHP 5** installed with **pdo_mysql** and **json** extensions (the result of `php -m` should include pdo_mysql and json). On Debian based (Debian/Ubuntu/Mint) Linux you can install it using `sudo apt-get install php5-mysql php5-json`
 * In some cases installation of **xml** extension may be required for php (`sudo apt-get install php-xml`). Especially if you see **Attempt to load class "DOMDocument" from global namespace** 
 * You must have  **MySQL** or **MariaDB** installed or run it using docker (see below in Setup/Database configuration)
 
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

If you have the docker and docker-compose then all you have to do is to run `docker-compose up -d` and you have db ready to go. ([Install Docker Engine](https://docs.docker.com/engine/installation/), [Install Docker Compose](https://docs.docker.com/compose/install/), remember to add user to docker group after installing it `sudo usermod -a -G docker YourUserName`)

If you do not have docker then you must install MySQL or MariaDB to have access to port `3306` (default port) and there must be a created database named `realskill` to which the user `realskill` with  `realskill` password has access.
```
$ mysql -u root -p
mysql> create database realskill;
mysql> grant usage on *.* to realskill@localhost identified by 'realskill';
mysql> grant all privileges on realskill.* to realskill@localhost ;
```


**Now you can access the website via http://127.0.0.1:8000**

Good luck!
