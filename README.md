# Symfony 2.8 - Exercise 6 - OAuth2 Server


## Summary

The expected result of this task is an application which allows the user to register and login. After logging in the user should be able to create OAuth Clients (to perform three-legged authentication) and Personal Access Tokens (to use Authorization while consuming API).

This task is considered completed when all tests are passing and when the code-sniffer and the mess-detector do not return errors or warnings (ignore the info about "Remaining deprecation notices" while testing).

Unfortunately due to the fact that we use ORMPurger::PURGE_MODE_DELETE during seeding tests they take longer time.

If you want to see which goals you have achieved you should run: `php app/composer test-dox`. Each scenario with **[x]** has passed and those with **[ ]** still have to be done.

More info about errors during tests you can get by running tests with the command: `php app/composer test`

## Goals

In order to complete this exercise you will need to follow these steps:

1. Install and configure **FOSUserBundle** to allow registering the user's account and login.
 * all entities created for **FOSUserBundle** should be placed inside App\Entity namespace
 * while entering `/register` the client should see:
    * the login link
    * the form with inputs:
        * email with id `fos_user_registration_form_email`
        * username with id `fos_user_registration_form_username`
        * password with id `fos_user_registration_form_plainPassword_first`
        * password repeat with id `fos_user_registration_form_plainPassword_second`
        * token with id `fos_user_registration_form__token`
 * it should not register the user with duplicated email address
 * it should register the user if all inputs have been filled, and should redirect them to `/register/confirmed`
 * while entering `/login` the client should see:
    * the form with inputs:
        * username with id `username`
        * password with id `password`
 * if proper credentials have been passed to the login form then the user should be logged in and redirected to homepage `/`    

2. Modify homepage accessed via GET `/`:
 * if the user is not authenticated, then **Register** and **Login** link should be displayed inside the element with id `authentication`
 * if the user is authenticated, then inside the element with id `authenticated` they should see:
    * their username inside `strong` element
    * **Logout** link
    * **Create OAuth2 client** link to `/oauth/v2/create_client` created in the next steps

3. Install and configure **FOSOAuthServerBundle**
 * all entities created for OAuth2 should be placed inside App\Entity namespace
 * Create the page accessed via GET `/oauth/v2/create_client`which:
   * should display **Create OAuth2 Client** inside h1
   * should display the form containing input with name `redirect_url` and **Create** submit
   * should display **Back to homepage** link to homepage `/`
   * if the form has been submitted and the user is not authenticated, it should redirect them to the login page `/login`
   * if the form has been submitted and user is authenticated, it should:
        * create OAuth2 client with redirect url being set to value from the form
        * redirect to `oauth/v2/auth` with a querystring to ask the user if they want to **Allow** or **Deny** access
        * if **Deny** has been chosen it should redirect them to the given `redirect_url` with the error in querystring set to `access_denied`
        * if **Allow** has been chosen it should redirect them to the given `redirect_url` with a code in querystring

4. Create route secured with OAuth2 :
 * it should be accessed via GET `/api/test` and if the user is authenticated using OAuth2 token it should return
 ```
    [ 'status' => 'accessGranted' ]
 ```
 * if no token has been provided in headers it should return 
 ```
    [
        'error' => 'access_denied',
        'error_description' => 'OAuth2 authentication required',
    ]
 ``` 
 * if a token has been provided but it is wrong it should return
 ```
    [
        'error' => 'invalid_grant',
        'error_description' => 'The access token provided is invalid.',
    ]
 ```
 * if a token has been provided and it is legit it should return a response for the authenticated user 
         
The expected results of `php app/composer test-dox` for the completed exercise are listed below:
```
AppBundle\Tests\Feature\CreateOauth2ClientFeature
 [x] Should authenticate
 [x] Should see the proper header
 [x] Should see the back to homepage link
 [x] Should see the form with redirect url input and create the submit button
 [x] Should create oauth client if the form has been submitted
 [x] Should redirect you to allow or deny form after creating the oauth client
 [x] Should redirect you to callback with error access denied if authorizing oauth client is rejected
 [x] Should redirect you to callback with auth code token if authorizing oauth client is allowed
 [x] Should return access denied for oauth secured route if no token is provided
 [x] Should return invalid grant for oauth secured route if wrong token is provided
 [x] Should allow creating tokens using username and password if proper client has been created
 [x] Should allow access for oauth secured route if the legit token is provided

AppBundle\Tests\Feature\LoginFeature
 [x] Should see the login form
 [x] Should not login if there is proper payload but the account is disabled
 [x] Should login if there is proper payload

AppBundle\Tests\Feature\MainPageAuthenticationLinksFeature
 [x] Should see the register link
 [x] Should see the login link

AppBundle\Tests\Feature\MainPageBeingAuthenticatedPageFeature
 [x] Should authenticate
 [x] Should see the login name
 [x] Should see the logout link
 [x] Should see the create oauth client link

AppBundle\Tests\Feature\RegisterFeature
 [x] Should see the login link
 [x] Should see the egistration form
 [x] the form should contain proper inputs
 [x] Should not register the user with duplicated email address
 [x] Should register the user with the proper input
```


## Hints

Most of the changes should lay in `src` dir. You can also modify templates in `app/Resources/views`. If needed you can also modify config and other files in `app` dir.

If you want to see which goals you have achieved you should run: `php app/composer test-dox`. Each scenario with **[x]** has passed and those with **[ ]** still have to be done.

More info about errors during tests you can get by running tests with the command: `php app/composer test`

This task is considered completed when all the tests are passing and when the code-sniffer and the mess-detector do not return errors or warnings (ignore the info about "Remaining deprecation notices" while testing).

Remember to commit changes before you change the branch.

Remember to install dependencies if you change the branch.

### Helpful links

Please remember to read the documentation for Symfony 2.8 because its newer and older versions may differ.

* [Symfony documentation](https://symfony.com/doc/2.8/page_creation.html)

## Requirements

 * You must have  **PHP 5** installed with **pdo_mysql** and **json** extensions (the result of `php -m` should include pdo_mysql and json). On Debian based (Debian/Ubuntu/Mint) Linux you can install it using `sudo apt-get install php5-mysql php5-json`
 * In some cases installation of **xml** extension may be required for php (`sudo apt-get install php-xml`). Especially if you see **Attempt to load class "DOMDocument" from global namespace** 
 * You must have  **MySQL** or **MariaDB** installed or run using docker (see below in Setup/Database configuration)
 
## Setup

### To install dependencies

    php app/composer install

### To run tests

    php app/composer test

### To run tests as documentation

    php app/composer test-dox
    
### to run static analytics mess detector

    php app/composer mess-detector
    
### To run static analytics code sniffer

    php app/composer code-sniffer


## to run php server

    php app/console server:run
    
## Database configuration

You must have  database configured to be able to run tests and the website.

If you have the docker and docker-compose then all you have to do is to run `docker-compose up -d` and you have db ready to go. ([Install Docker Engine](https://docs.docker.com/engine/installation/), [Install Docker Compose](https://docs.docker.com/compose/install/), remember to add the user to docker group after installing it `sudo usermod -a -G docker YourUserName`)

If you do not have the docker then you must install MySQL or MariaDB to have access to port `3306` (default port) and there must be  database created and named `realskill`, to which the user `realskill` with  `realskill` password has access.
```
$ mysql -u root -p
mysql> create database realskill;
mysql> grant usage on *.* to realskill@localhost identified by 'realskill';
mysql> grant all privileges on realskill.* to realskill@localhost ;
```


**Now you can access the website via http://127.0.0.1:8000**

Good luck!
