# Laravel - Exercise 2 - Simple CRUD


## Summary

The expected result of this task is an application which allows users to create/read/update/delete row in the table.

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

To make your task easier in terms of forms we have installed `laravelcollective/html`


## Goals

In order to complete this exercise you will need to follow these steps:

1. Create `Book` model in `app/Book.php` with proper `namespace`.

2. Create migration to create  `books`table with columns listed below:
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

3. Create a page to display the list of books, which:
  * should be accessed via GET on "/book" route with name "book.index"
  * should contain: 
    * "Books" in `h1` heading
    * table with thead and headers: "ID", "Title", "Author", "Price", "Actions" with class name, accordingly "id", "title", "author", "price", "actions"
    * inside the table's tbody each book should display data for each column as the header suggests, each column should have a class name as the header
    * inside the table's tbody last column should contain 3 buttons with actions: "Show", "Edit", "Delete" (the last one requires a form to perform action). Each button should redirect you to the proper page, as described in the next steps
    * under the table there should be a "Create" button which redirects you to the "book.create" route
    
4. Create StoreBook request to validate incoming data before storing it in db

5. Create a page to display the form creating new book entry, which:
  * should be accessed via GET "/book/create"
  * should display an "Index" link which redirects you to the "book.index" route
  * should display "Create book" in `h1` heading
  * should display the form with:
    * "Title:" label for "title" input
    * "title" input of type "text"
    * "Author:" label for "author" input
    * "author" input of type "text"
    * "Price:" label for "price" input
    * "price" input of type "number" with HTML5 validation of minimal number value equal 0
    * "Save book" button to submit form
  * if the submitted data is invalid it should return to "book.create" route and display proper errors
  * if the submitted data is valid it should save the book in db, redirect you to "book.index" route, and show flash message "Successfully created book!"
  
6. Create a page to display a form to edit book that:
  * should be accessed via GET "/book/{id}/edit"
  * should display "Index" link which redirects you to the "book.index" route
  * should display "Edit {{ $book->title }}" in `h1` heading
  * should display the form with:
    * Data of the edited book 
    * "Title:" label for "title" input
    * "title" input of type "text"
    * "Author:" label for "author" input
    * "author" input of type "text"
    * "Price:" label for "price" input
    * "price" input of type "number" with HTML5 validation of minimal number value that equals 0
    * "Save book" button to submit the form
  * if the submitted data is invalid it should return to the "book.create" route and display proper errors
  * if the submitted data is valid it should save the book in db, redirect you to the "book.index" route, and show flash message "Successfully updated book!"

7. Create a page to display the book info that:
  * should be accessed via GET "/book/{id}"
  * should display the book title in `h1` heading
  * should display an element with "author" class which contains:
    * strong with text "Author:"
    * span with the author of the book
  * should display an element with class "price" which contains:
    * strong with text "Price:"
    * span with the price of the book with a dollar sign eg. "6.43 $"
  * should display "Edit" link which redirects you to "book.edit" route to edit this book
  * if such a book does not exist, it should return 404
  
8. Create an endpoint to delete the book that:
  * should be accessed via "DELETE" "/book/{id}"
  * if such a book does not exist, it should return 404
  * if such a book exists, it should delete it from the database, redirect you to "book.index", and show flash message "Successfully deleted book!"

The expected results of `php composer test-dox` for the completed exercise are listed below:
```
CreateBook
 [x] Should see the index button
 [x] Should see the proper header
 [x] Should see the title input of type text in the form
 [x] Should see the author input of type text in the form
 [x] Should see the price input of type number with html 5 min number validation in the form
 [x] Should see the submit button with text save book in the form
 [x] Should not save the book if the title is too short and should show proper error message
 [x] Should not save the book if the title is too long and should show proper error message
 [x] Should not save the book if the author's name is too short and should show proper error message
 [x] Should not save the book if the author's name is too long and should show proper error message
 [x] Should not save the book if the price is a negative value
 [x] Should save the book if proper values have been given and should redirect you to the book index and display flash message

DeleteBook
 [x] Should return 404 if no such book exists
 [x] Should delete indicated book and redirect you to the book index and display flash message

RetrieveBook
 [x] Should return 404 if no such book exists
 [x] Should see the index button
 [x] Should see the book title as a heading
 [x] Should see the author's name
 [x] Should see the price with a dollar sign
 [x] Should see the edit button

RetrieveBooks
 [x] Should see the books header
 [x] Should see the book list table header
 [x] Should see the book list table content
 [x] Should see the button show for each book with the proper link
 [x] Should see the edit button for each book with the proper link
 [x] Should see the delete button for each book within the form to perform delete operation
 [x] Should see the create button


UpdateBook
 [x] Should see the proper header
 [x] Should see the index button
 [x] Should see the title input of type text in the form
 [x] Should see the author input of type text in form
 [x] Should see the price input of type number with html 5 min number validation in the form
 [x] Should see the submit button with text save book in the form
 [x] Should not save the book if the title is too short and should show proper error message
 [x] Should not save the book if the title is too long and should show proper error message
 [x] Should not save the book if the author's name is too short and should show proper error message
 [x] Should not save the book if the author's name is too long and should show proper error message
 [x] Should not save the book if the price is negative
 [x] Should save the book if proper values have been given and should redirect you to book index and display flash message
```

## Hints

Most of the changes should lay in `app` dir. You can also modify files in `database/migrations`, `routes` and `resources`.

If you want to see which goals you have achieved you should run: `php composer test-dox`. Each scenario with **[x]** has passed and those with **[ ]** still have to be done.

More info about the errors during the tests you can get by running tests with the command: `php composer test`

This task is concsidered completed when all tests are passing and when the code-sniffer and the mess-detector do not return errors or warnings (ignore the info about "Remaining deprecation notices" during the test).

Remember to commit changes before you change the branch.

Remember to install dependencies if you change the branch.

### Helpful links

Please remember to read the documentation for Laravel 5.3 because the newer version can differ from the older one. 

* [Laravel documentation](https://laravel.com/docs/5.3)

## Requirements

 * You must have  **PHP 5** installed with **pdo_mysql** and **json** extensions (result of `php -m` should include pdo_mysql and json). On Debian based (Debian/Ubuntu/Mint) Linux you can install it using `sudo apt-get install php5-mysql php5-json`
 * In some cases installation of **xml**  extension can be required for php (`sudo apt-get install php-xml`), especially if you see **Attempt to load class "DOMDocument" from global namespace** 
 * You must have  **MySQL** or **MariaDB** installed or you should run it using docker (see below in Setup/Database configuration)

 
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

You must have database configured to be able to run the tests and the website.

If you have docker and docker-compose then all you have to do is to run `docker-compose up -d` and you have db ready to go. ([Install Docker Engine](https://docs.docker.com/engine/installation/), [Install Docker Compose](https://docs.docker.com/compose/install/), remember to add the user to the docker group after installing it `sudo usermod -a -G docker YourUserName`)

If you do not have docker you must install MySQL or MariaDB to have access to port `3306` (default port) and there must be  database created and named `realskill` to which the user `realskill` with  `realskill` password has access.
```
$ mysql -u root -p
mysql> create database realskill;
mysql> grant usage on *.* to realskill@localhost identified by 'realskill';
mysql> grant all privileges on realskill.* to realskill@localhost ;
```


**Now you can access the website via http://127.0.0.1:8000**

Good luck!
