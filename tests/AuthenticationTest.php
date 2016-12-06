<?php

class AuthenticationTest extends TestCase
{
    /**
     * @before
     */
    public function seedUsers()
    {
        $this->seed(UsersTableSeeder::class);
    }

    /**
     * @test
     */
    public function shouldSeeRegisterLinkOnMainPage()
    {
        $this->visit('/')->within('.top-right.links', function () {
            $this->seeLink('Register', '/register');
        });
    }

    /**
     * @test
     */
    public function shouldSeeLoginLinkOnMainPage()
    {
        $this->visit('/')->within('.top-right.links', function () {
            $this->seeLink('Login', '/login');
        });
    }

    /**
     * @test
     * @depends shouldSeeRegisterLinkOnMainPage
     */
    public function shouldSeeRegisterFormOnRegisterPage()
    {
        $this->visit('/register')
            ->seeInElement('.panel-heading', 'Register')
            ->seeElement('form', ['method' => 'POST'])
            ->within('form', function () {
                $this
                    ->seeInElement('label[for=name]', 'Name')
                    ->seeElement('#name', ['type' => 'text', 'name' => 'name'])
                    ->seeInElement('label[for=email]', 'E-Mail Address')
                    ->seeElement('#email', ['type' => 'email', 'name' => 'email'])
                    ->seeInElement('label[for=password]', 'Password')
                    ->seeElement('#password', ['type' => 'password', 'name' => 'password'])
                    ->seeInElement('label[for=password-confirm]', 'Confirm Password')
                    ->seeElement('#password-confirm', ['type' => 'password', 'name' => 'password_confirmation'])
                    ->seeInElement('button[type=submit]', 'Register');
            });
    }

    /**
     * @test
     * @depends shouldSeeLoginLinkOnMainPage
     */
    public function shouldSeeLoginFormOnLoginPage()
    {
        $this->visit('/login')
            ->seeInElement('.panel-heading', 'Login')
            ->seeElement('form', ['method' => 'POST'])
            ->within('form', function () {
                $this
                    ->seeInElement('label[for=email]', 'E-Mail Address')
                    ->seeElement('#email', ['type' => 'email', 'name' => 'email'])
                    ->seeInElement('label[for=password]', 'Password')
                    ->seeElement('[type=checkbox]', ['name' => 'remember'])
                    ->seeInElement('.checkbox', 'Remember Me')
                    ->seeElement('#password', ['type' => 'password', 'name' => 'password'])
                    ->seeInElement('button[type=submit]', 'Login')
                    ->seeLink('Forgot Your Password?', '/password/reset');
            });
    }

    /**
     * @test
     * @depends shouldSeeRegisterFormOnRegisterPage
     */
    public function shouldNotRegisterNewUserIfExistingEmailHasBeenSubmitted()
    {
        $this->seeInDatabase('users', [
            'name' => 'Hakier',
            'email' => 'hakier@fake.pl',
        ]);
        $this->notSeeInDatabase('users', [
            'name' => 'Hakier-pretender',
            'email' => 'hakier@fake.pl',
        ]);
        $this->visit('/register')->submitForm('Register', [
            'name' => 'Hakier-pretender',
            'email' => 'hakier@fake.pl',
            'password' => 'hakier-pretender-password',
            'password_confirmation' => 'hakier-pretender-password',
        ]);
        $this->seePageIs('/register');
        $this->see('The email has already been taken.');
        $this->notSeeInDatabase('users', [
            'name' => 'Hakier-pretender',
            'email' => 'hakier@fake.pl',
        ]);
    }

    /**
     * @test
     * @depends shouldSeeRegisterFormOnRegisterPage
     */
    public function shouldRegisterNewUserIfProperDataHasBeenSubmitted()
    {
        $this->notSeeInDatabase('users', [
            'name' => 'John Doe',
            'email' => 'john.doe@fake.pl',
        ]);
        $this->visit('/register')->submitForm('Register', [
            'name' => 'John Doe',
            'email' => 'john.doe@fake.pl',
            'password' => 'john.doe-password',
            'password_confirmation' => 'john.doe-password',
        ]);
        $this->seePageIs('/home');
        $this->seeInDatabase('users', [
            'name' => 'John Doe',
            'email' => 'john.doe@fake.pl',
        ]);
    }

    /**
     * @test
     * @depends shouldSeeLoginLinkOnMainPage
     */
    public function shouldNotLoginUserIfBadPasswordHasBeenGiven()
    {
        $this->visit('/login')->submitForm('Login', [
            'email' => 'hakier@fake.pl',
            'password' => 'hakier-bad-password'
        ]);
        $this->seePageIs('/login');
        $this->see('These credentials do not match our records.');
    }

    /**
     * @test
     * @depends shouldSeeLoginLinkOnMainPage
     */
    public function shouldLoginUserIfGoodCredentialsHasBeenSubmitted()
    {
        $this->visit('/login')->submitForm('Login', [
            'email' => 'hakier@fake.pl',
            'password' => 'hakier-password'
        ]);
        $this->seePageIs('/home');
    }
}
