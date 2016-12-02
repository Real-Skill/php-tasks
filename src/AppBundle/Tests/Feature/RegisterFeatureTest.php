<?php

namespace AppBundle\Tests\Feature;

use AppBundle\DataFixtures\ORM\LoadUserData;
use AppBundle\Entity\User;
use AppBundle\Tests\AbstractFixtureAwareWebTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class DefaultControllerTest
 * @package AppBundle\Tests\Controller
 */
class RegisterFeatureTest extends AbstractFixtureAwareWebTestCase
{
    protected $purgeMode = ORMPurger::PURGE_MODE_DELETE;

    /**
     * @before
     */
    public function visitLoginPage()
    {
        $this->crawler = $this->client->request('GET', '/register/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }


    /**
     * @test
     */
    public function shouldSeeLoginLink()
    {
        $this->assertCount(1, $this->crawler->filter('a[href^="/login"]'));
    }

    /**
     * @test
     */
    public function shouldSeeRegistrationForm()
    {
        $this->assertCount(1, $this->crawler->filter('form[action^="/register"]'));
    }

    /**
     * @test
     * @depends shouldSeeRegistrationForm
     */
    public function formShouldContainProperInputs()
    {
        $requiredInputs = [
            '#fos_user_registration_form_email',
            '#fos_user_registration_form_username',
            '#fos_user_registration_form_plainPassword_first',
            '#fos_user_registration_form_plainPassword_second',
            '#fos_user_registration_form__token',
        ];
        foreach ($requiredInputs as $requiredInput) {
            $this->assertCount(1, $this->crawler->filter($requiredInput));
        }
    }

    /**
     * @test
     * @depends shouldSeeRegistrationForm
     */
    public function shouldNotRegisterUserWithDuplicatedEmail()
    {
        $form = $this->crawler->selectButton('Register')->form();

        $this->client->followRedirects(true);
        $this->client->submit($form, [
            'fos_user_registration_form[email]' => 'martin.fowler@fake.pl',
            'fos_user_registration_form[username]' => 'hakier',
            'fos_user_registration_form[plainPassword][first]' => 'hakier-pass',
            'fos_user_registration_form[plainPassword][second]' => 'hakier-pass',
        ]);
        $this->assertEquals('/register/', $this->client->getRequest()->getPathInfo());

        /**
         * @var User $user
         */
        $user = $this->manager->getRepository('AppBundle:User')->findOneBy(['username' => 'hakier']);

        $this->assertEmpty($user, 'Should not create user');
    }

    /**
     * @test
     * @depends shouldSeeRegistrationForm
     */
    public function shouldRegisterUserWithProperInput()
    {
        $form = $this->crawler->selectButton('Register')->form();

        $this->client->followRedirects(true);
        $this->client->submit($form, [
            'fos_user_registration_form[email]' => 'hakier@fake.pl',
            'fos_user_registration_form[username]' => 'hakier',
            'fos_user_registration_form[plainPassword][first]' => 'hakier-pass',
            'fos_user_registration_form[plainPassword][second]' => 'hakier-pass',
        ]);
        $this->assertEquals('/register/confirmed', $this->client->getRequest()->getPathInfo());

        /**
         * @var User $user
         */
        $user = $this->manager->getRepository('AppBundle:User')->findOneBy(['username' => 'hakier']);

        $this->assertNotEmpty($user, 'Should create user');
        $this->assertEquals('hakier', $user->getUsername());
        $this->assertEquals('hakier@fake.pl', $user->getEmail());
    }

    /**
     * @return array
     */
    protected function getFixtures()
    {
        return [new LoadUserData()];
    }
}
