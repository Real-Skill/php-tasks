# Laravel - Exercise 2 - Simple CRUD


## Summary

Expected result of this task is an application which allows user to create/read/update/delete row in the table.

Sample book structure:
```
[
    'title' => 'Test Driven Development: By Example',
    'author' => 'Kent Beck',
    'price' => 39.51,
    'created_at' => '2016-11-07 19:26:55',
    'updated_at' => '2016-11-07 19:26:55',
]
```

To ease Your task with forms We have installed `laravelcollective/html`


## Goals

In order to complete this exercise you will need to follow these steps:

1. Create `Book` model in `app/Book.php` with proper `namespace`.

2. Create migration to create table `books` with columns listed below:

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
  * timestamps - created_at, updated_at (Blueprint has method to do it)

3. Create page to display list of books
  * should be accessed via GET on "/book" route with name "book.index"
  * page should contain: 
    * "Books" in `h1` heading
    * table with thead and headers: "ID", "Title", "Author", "Price", "Actions" with class name accordingly "id", "title", "author", "price", "actions"
    * inside table's tbody each book should display data for each column as the header suggests, each column should has class name like header
    * inside table's tbody last column should contain 3 buttons with actions: "Show", "Edit", "Delete" (this one require form to perform action). Ecah button should redirect to proper page described in next steps
    * under table there should be "Create" button which redirects to "book.create" route
    
4. Create StoreBook request to validate incoming data before storing it in db

5. Create page to display form to create new book
  * should be accessed via GET "/book/create"
  * should display link "Index" which redirects to "book.index" route
  * should display "Create book" in `h1` heading
  * should display form with:
    * "Title:" label for "title" input
    * "title" input of type "text"
    * "Author:" label for "author" input
    * "author" input of type "text"
    * "Price:" label for "price" input
    * "price" input of type "number" with HTML5 validation of minimal number value equal 0
    * "Save book" button to submit form
  * if submitted data is invalid it should return to "book.create" route and display proper errors
  * if submitted data is valid it should save book in db and redirect to "book.index" route and show flash message "Successfully created book!"
  
6. Create page to display form to edit book
  * should be accessed via GET "/book/{id}/edit"
  * should display link "Index" which redirects to "book.index" route
  * should display "Edit {{ $book->title }}" in `h1` heading
  * should display form with:
    * Data of book being edited
    * "Title:" label for "title" input
    * "title" input of type "text"
    * "Author:" label for "author" input
    * "author" input of type "text"
    * "Price:" label for "price" input
    * "price" input of type "number" with HTML5 validation of minimal number value equal 0
    * "Save book" button to submit form
  * if submitted data is invalid it should return to "book.create" route and display proper errors
  * if submitted data is valid it should should save book in db and redirect to "book.index" route and show flash message "Successfully updated book!"

7. Create page to display book info
  * should be accessed via GET "/book/{id}"
  * should display book title in `h1` heading
  * should display element with class "author" which contains:
    * strong with text "Author:"
    * span with author of the book
  * should display element with class "price" which contains:
    * strong with text "Price:"
    * span with price of the book with dollar sign eg. "6.43 $"
  * should display "Edit" link which redirects to "book.edit" route to edit this book
  * if such book not exist it should return 404
  
8. Create endpoint to delete book
  * should be accessed via "DELETE" "/book/{id}"
  * if such book does not exist it should return 404
  * if such book exist it should delete it from database and redirect to "book.index" and show flash message "Successfully deleted the book!"

Expected result of `php composer test-dox` for completed exercise is listed below:
```
CreateBook
 [x] Should see index button
 [x] Should see proper header
 [x] Should see title input of type text in form
 [x] Should see author input of type text in form
 [x] Should see price input of type number with html 5 min number validation in form
 [x] Should see submit button with text save book in form
 [x] Should not save book if title is too short and show proper error message
 [x] Should not save book if title is too long and show proper error message
 [x] Should not save book if author is too short and show proper error message
 [x] Should not save book if author is too long and show proper error message
 [x] Should not save book if price is negative
 [x] Should save book if proper values has been given and redirect to book index and display flash message

DeleteBook
 [x] Should return 404 if no such book
 [x] Should delete concrete book and redirect to book index and display flash message

RetrieveBook
 [x] Should return 404 if no such book
 [x] Should see index button
 [x] Should see book title as heading
 [x] Should see author
 [x] Should see price with dollar sign
 [x] Should see edit button

RetrieveBooks
 [x] Should see books header
 [x] Should see books list table header
 [x] Should see books list table content
 [x] Should see button show for each book with proper link
 [x] Should see button edit for each book with proper link
 [x] Should see button delete for each book within form to perform delete operation
 [x] Should see create button


UpdateBook
 [x] Should see proper header
 [x] Should see index button
 [x] Should see title input of type text in form
 [x] Should see author input of type text in form
 [x] Should see price input of type number with html 5 min number validation in form
 [x] Should see submit button with text save book in form
 [x] Should not save book if title is too short and show proper error message
 [x] Should not save book if title is too long and show proper error message
 [x] Should not save book if author is too short and show proper error message
 [x] Should not save book if author is too long and show proper error message
 [x] Should not save book if price is negative
 [x] Should save book if proper values has been given and redirect to book index and display flash message
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
