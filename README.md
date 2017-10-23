# Laravel - Exercise 1 - Simple CRUD on REST


## Summary

{summary}

The expected result of this task is an application which allows the user to create/read/update/delete a row in the table using REST requests.

Sample book structure:
```
[
    'id' => 1,
    'title' => 'Patterns of Enterprise Application Architecture',
    'author' => 'Martin Fowler',
    'price' => '15.96'
]
```


## Goals

In order to complete this exercise you will need to follow these steps:

1. Create `Book` model in `app/Book.php` with proper `namespace`.

2. Create migration to create the table `books` with columns listed below:

  * id - primary key, autoincrement
  * title - type: `string`, length: 128, assertions before persisting data from controller:
    * not blank
    * min length = 3
    * max length = 128
  * author - type: `string`, length: 128, assertions before persisting data from controller: 
    * not blank
    * min length = 3
    * max length = 128
  * price - type: `float`, assertions before persisting data from controller: 
    * numeric
    * min value: 0
  
2. Create an endpoint to retrieve the list of books that:
  * should be accessed via GET "/api/book"
  * should return array of books as JSON
  
3. Create an endpoint to create a new book entry that:
  * should be accessed via POST "/api/book"
  * should validate if the payload is valid
  * if the payload is invalid it should return JSON with error messages per each property with **HTTP_UNPROCESSABLE_ENTITY** status code eg:
  ```
  {
    "author": "The author's name must be between 3 and 128 characters."
  }
  ```
  * if the payload is valid it should store `Book` data and return JSON response data of the newly created `Book`, eg.:
  ```
  {
    "id": 1,
    "title": "Test Driven Development: By Example",
    "author": "Kent Beck",
    "price": "39.51",
    "created_at": "2016-11-07 19:26:55",
    "updated_at": "2016-11-07 19:26:55"
  }
  ```
  
4. Create an endpoint to update existing books, which:
  * should be accessed via PUT "/api/book/{bookId}"
  * should validate if the payload is valid
  * should assign the title, author's name from request to `Book` object
  * if `Book` with given `bookId` does not exist, it should return **NOT_FOUND** status code
  * if the payload is invalid, it should return JSON with error messages per each property with **HTTP_UNPROCESSABLE_ENTITY** status code eg:
  ```
  {
    "author": "The author's name must be between 3 and 128 characters."
  }
  ```
  * if the payload is valid, it should store `Book` data and return JSON response data of the newly created `Book`, eg.:
  ```
  {
    "id": 1,
    "title": "Test Driven Development: By Example",
    "author": "Kent Beck",
    "price": "39.51",
    "created_at": "2016-11-07 19:26:55",
    "updated_at": "2016-11-07 19:26:55"
  }
  ```

5. Create an endpoint to delete an existing book, which:
  * should be accessed via DELETE "/api/book/{bookId}"
  * if `Book` with given `bookId` does not exist, it should return **NOT_FOUND** status code
  * if `Book` with given `bookId` exists, it should delete it and return **HTTP_ACCEPTED** status code

The expected results of `php composer test-dox` for completed exercise are listed below:
```
CreateBook
 [x] Should not save the book with empty payload
 [x] Should not save the book with empty title
 [x] Should not save the book with empty author
 [x] Should not save the book with empty price
 [x] Should not save the book with too short title
 [x] Should not save the book with too long title
 [x] Should not save the book with too short author's name
 [x] Should not save the book with too long author's name
 [x] Should not save the book with a negative price value
 [x] Should not save the book with invalid string price
 [x] Should save the book with proper payload and should return its data


DeleteBook
 [x] Should return 404 status code if the book does not exist
 [x] Should return certain book data if the book exists

RetrieveBook
 [x] Should return 404 status code if the book does not exists
 [x] Should return certain book data if the book exists

RetrieveBooks
 [x] Should return books data

UpdateBook
 [x] Should save the book with proper payload and should return its data
 [x] Should not save the book with empty payload
 [x] Should not save the book with empty title
 [x] Should not save the book with empty author
 [x] Should not save the book with empty price
 [x] Should not save the book with too short title
 [x] Should not save the book with too long title
 [x] Should not save the book with too short author's name
 [x] Should not save the book with too long author's name
 [x] Should not save the book with negative price value
 [x] Should not save the book with invalid string price
```


## Hints

Most of the changes should lay in `app` dir. You can also modify files in `database/migrations`, `routes` and `resources`.

If you want to see which goals you have achieved you should run: `php composer test-dox`. Each scenario with **[x]** has passed and those with **[ ]** still have to be done.

More info about errors during tests you can get by running tests with command: `php composer test`

This task is considered done when all tests are passing and when the code-sniffer and the mess-detector do not return errors or warnings (ignore the info about "Remaining deprecation notices" while testing).

Remember to commit changes before you change the branch.

Remember to install dependencies if you change the branch.

### Helpful links

Please remember to read documentation for Laravel 5.3 because the newer version can differ to the older ones.

* [Laravel documentation](https://laravel.com/docs/5.3)

## Requirements

 * You must have  **PHP 5** installed with **pdo_mysql** and **json** extensions (the result of `php -m` should include pdo_mysql and json). On Debian based (Debian/Ubuntu/Mint) Linux you can install it using `sudo apt-get install php5-mysql php5-json`
 * In some cases installation of **xml** extension may be required for php (`sudo apt-get install php-xml`). Especially if you see **Attempt to load class "DOMDocument" from global namespace** 
 * You must have  **MySQL** or **MariaDB** installed or run it using docker (see below in Setup/Database configuration)
 
 
## Setup

### To install dependencies

    php composer install

### To run tests

    php composer test

### To run tests as documentation

    php composer test-dox
    
### To run static analytics mess detector

    php composer mess-detector
    
### To run static analytics code sniffer

    php composer code-sniffer


## To run php server

    php artisan serve
    
    
## Database configuration

You must have the database configured to be able to run tests and the website.

If you have docker and docker-compose then all you have to do is to run `docker-compose up -d` and you have db ready to go. ([Install Docker Engine](https://docs.docker.com/engine/installation/), [Install Docker Compose](https://docs.docker.com/compose/install/), remember to add the user to docker group after installing it `sudo usermod -a -G docker YourUserName`)

If you do not have docker then you must install MySQL or MariaDB to have access to port `3306` (default port) and there must be  database named `realskill` created to which the user `realskill` with  `realskill` password has access.
```
$ mysql -u root -p
mysql> create database realskill;
mysql> grant usage on *.* to realskill@localhost identified by 'realskill';
mysql> grant all privileges on realskill.* to realskill@localhost ;
```


**Now you can access website via http://127.0.0.1:8000**

Good luck!
