# Symfony 2.8 - Exercise 6 - OAuth2 Server


## Summary

Expected result of this task is an applications which allows user to register and login. After logging in user should be able to create OAuth Clients (to perform three legged authentication) and Personal Access Tokens (to use Authorization while consuming API).

This task is concerned as done when all tests are passing and when code-sniffer and mess-detector do not return errors nor warnings (ignore info about "Remaining deprecation notices" during test).

Unfortunately due to used ORMPurger::PURGE_MODE_DELETE during seeding tests they take longer time.

If You want to see what goals You have passed You should run: `php app/composer test-dox`. Each scenario with **[x]** has passed and those with **[ ]** has to be done.

More info about errors during tests You can get running tests with command: `php app/composer test`

## Goals

In order to complete this exercise you will need follow these steps:

1. Install and configure **FOSUserBundle** to allow registering user account and login.
 * all entities created for **FOSUserBundle** should be placed inside App\Entity namespace
 * when enter `/register` client should see:
    * login link
    * form with inputs:
        * email with id `fos_user_registration_form_email`
        * username with id `fos_user_registration_form_username`
        * password with id `fos_user_registration_form_plainPassword_first`
        * password repeat with id `fos_user_registration_form_plainPassword_second`
        * token with id `fos_user_registration_form__token`
 * should not register user with duplicated email
 * should register user if all inputs has been filled and redirect him to `/register/confirmed`
 * when enter `/login` client should see:
    * form with inputs:
        * username with id `username`
        * password with id `password`
 * if proper credentials has been passed to login form then user should be logged in and redirected to homepage `/`    

2. Modify homepage accessed via GET `/`:
 * if user is not authenticated then **Register** and **Login** link should be displayed inside element with id `authentication`
 * if user is authenticated then inside element with id `authenticated` he should see:
    * his username inside `strong` element
    * **Logout** link
    * **Create OAuth2 client** link to `/oauth/v2/create_client` created in next steps

3. Install and configure **FOSOAuthServerBundle**
 * all entities created for OAuth2 should be placed inside App\Entity namespace
 * Create page accessed via GET `/oauth/v2/create_client`
   * should display **Create OAuth2 Client** inside h1
   * should display form containing input with name `redirect_url` and **Create** submit
   * should display **Back to homepage** link to homepage `/`
   * if form has been submitted and user is not authenticated it should redirect him to login page `/login`
   * if form has been submitted and user is authenticated it should:
        * create OAuth2 client with redirect url being set to value from form
        * redirect to `oauth/v2/auth` with querystring to ask user if he wants to **Allow** or **Deny** access
        * if **Deny** has been chosen it should redirect to given `redirect_url` with error in querystring set to `access_denied`
        * if **Allow** has been chosen it should redirect to given `redirect_url` with code in querystring

4. Create secured with OAuth2 route
 * it should be accessed via GET `/api/test` and if user is authenticated using OAuth2 token it should return
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
 * if token has been provided but it is wrong it should return
 ```
    [
        'error' => 'invalid_grant',
        'error_description' => 'The access token provided is invalid.',
    ]
 ```
 * if token has been provided and is legit it should return response for authenticated user 
         
Expected result of `php app/composer test-dox` for completed exercise is listed below:
```
AppBundle\Tests\Feature\CreateOauth2ClientFeature
 [x] Should authenticate
 [x] Should see proper header
 [x] Should see back to homepage link
 [x] Should see form with redirect url input and create submit button
 [x] Should create oauth client if form has been submitted
 [x] Should redirect to allow or deny form after creating oauth client
 [x] Should redirect to callback with error access denied if authorizing oauth client rejected
 [x] Should redirect to callback with auth code token if authorizing oauth client allowed
 [x] Should return access denied for oauth secured route if no token provided
 [x] Should return invalid grant for oauth secured route if wrong token provided
 [x] Should allow creating token using username and password if proper client has been created
 [x] Should allow access for oauth secured route if legit token provided

AppBundle\Tests\Feature\LoginFeature
 [x] Should see login form
 [x] Should not login if proper payload but account is disabled
 [x] Should login if proper payload

AppBundle\Tests\Feature\MainPageAuthenticationLinksFeature
 [x] Should see register link
 [x] Should see login link

AppBundle\Tests\Feature\MainPageBeingAuthenticatedPageFeature
 [x] Should authenticate
 [x] Should see login name
 [x] Should see logout link
 [x] Should see create oauth client link

AppBundle\Tests\Feature\RegisterFeature
 [x] Should see login link
 [x] Should see registration form
 [x] Form should contain proper inputs
 [x] Should not register user with duplicated email
 [x] Should register user with proper input
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
