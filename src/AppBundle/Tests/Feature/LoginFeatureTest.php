<?php

namespace AppBundle\Tests\Feature;

use AppBundle\DataFixtures\ORM\LoadUserData;
use AppBundle\Entity\User;
use AppBundle\Tests\AbstractFixtureAwareWebTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use FOS\UserBundle\Util\PasswordUpdater;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultControllerTest
 * @package AppBundle\Tests\Controller
 */
class LoginFeatureTest extends AbstractFixtureAwareWebTestCase
{
    protected $purgeMode = ORMPurger::PURGE_MODE_DELETE;

    /**
     * @before
     */
    public function visitLoginPage()
    {
        $this->crawler = $this->client->request('GET', '/login');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldSeeLoginForm()
    {
        $this->assertCount(1, $this->crawler->filter('form[action^="/login_check"]'));
    }

    /**
     * @test
     * @depends shouldSeeRegistrationForm
     */
    public function formShouldContainProperInputs()
    {
        $requiredInputs = [
            '#username',
            '#password',
        ];
        foreach ($requiredInputs as $requiredInput) {
            $this->assertCount(1, $this->crawler->filter($requiredInput));
        }
    }

    /**
     * @test
     * @depends shouldSeeLoginForm
     */
    public function shouldNotLoginIfProperPayloadButAccountIsDisabled()
    {
        $user = $this->manager->getRepository('AppBundle:User')->findOneBy(['username' => 'martinFowler']);
        /**
         * @var PasswordUpdater $passwordUpdater
         */
        $passwordUpdater = $this->client->getContainer()->get('fos_user.util.password_updater');
        $passwordUpdater->hashPassword($user);
        $this->manager->persist($user);
        $this->manager->flush();

        $this->assertCount(1, $this->crawler->filter('input[value="Log in"]'));
        $form = $this->crawler->selectButton('Log in')->form();

        if ($form) {
            $this->client->followRedirects(true);
            $this->crawler = $this->client->submit($form, [
                '_username' => 'martinFowler',
                '_password' => 'pass'
            ]);
            $this->assertEquals('/login', $this->client->getRequest()->getPathInfo());
            $this->assertRegExp('/Account is disabled./', $this->crawler->text());
        }
    }

    /**
     * @test
     * @depends shouldSeeLoginForm
     */
    public function shouldLoginIfProperPayload()
    {
        $user = $this->manager->getRepository('AppBundle:User')->findOneBy(['username' => 'kentBeck']);
        /**
         * @var PasswordUpdater $passwordUpdater
         */
        $passwordUpdater = $this->client->getContainer()->get('fos_user.util.password_updater');
        $passwordUpdater->hashPassword($user);
        $this->manager->persist($user);
        $this->manager->flush();

        $this->assertCount(1, $this->crawler->filter('input[value="Log in"]'));
        $form = $this->crawler->selectButton('Log in')->form();

        if ($form) {
            $this->client->followRedirects(true);
            $this->crawler = $this->client->submit($form, [
                '_username' => 'kentBeck',
                '_password' => 'pass'
            ]);
            $this->assertNotEquals('/login', $this->client->getRequest()->getPathInfo());
            $this->assertNotRegExp('/Account is disabled./', $this->crawler->text());
        }
    }

    /**
     * @return array
     */
    protected function getFixtures()
    {
        return [new LoadUserData()];
    }
}
