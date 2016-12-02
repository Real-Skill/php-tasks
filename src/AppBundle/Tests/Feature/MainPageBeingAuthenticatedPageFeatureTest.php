<?php

namespace AppBundle\Tests\Feature;

use AppBundle\DataFixtures\ORM\LoadUserData;
use AppBundle\Tests\AbstractFixtureAwareWebTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

/**
 * Class DefaultControllerTest
 * @package AppBundle\Tests\Controller
 */
class MainPageBeingAuthenticatedPageFeatureTest extends AbstractFixtureAwareWebTestCase
{
    protected $purgeMode = ORMPurger::PURGE_MODE_DELETE;

    /**
     * @before
     */
    public function authenticate() {
        $form = $this->client->request('GET', '/login')->selectButton('Log in')->form();

        $this->client->followRedirects(true);
        $this->crawler = $this->client->submit($form, [
            '_username' => 'kentBeck',
            '_password' => 'pass'
        ]);

        $this->assertEquals('/', $this->client->getRequest()->getPathInfo());
        $this->assertNotRegExp('/Account is disabled./', $this->crawler->text());
        $this->client->followRedirects(false);
    }

    /**
     * @test
     */
    public function shouldAuthenticate()
    {
    }

    /**
     * @test
     * @depends shouldAuthenticate
     */
    public function shouldSeeLoginName()
    {
        $this->assertEquals('kentBeck', $this->crawler->filter('#authenticated strong')->text());
    }

    /**
     * @test
     * @depends shouldAuthenticate
     */
    public function shouldSeeLogoutLink()
    {
        $selectLink = $this->crawler->selectLink('Logout');
        $this->assertCount(1, $selectLink);
        $this->assertEquals('/logout', $selectLink->attr('href'));
    }

    /**
     * @test
     * @depends shouldAuthenticate
     */
    public function shouldSeeCreateOauthClientLink()
    {
        $selectLink = $this->crawler->selectLink('Create OAuth2 client');
        $this->assertCount(1, $selectLink);
        $this->assertEquals('/oauth/v2/create_client', $selectLink->attr('href'));
    }

    protected function getFixtures()
    {
        return [new LoadUserData()];
    }
}
