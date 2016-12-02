<?php

namespace AppBundle\Tests\Feature;

use AppBundle\DataFixtures\ORM\LoadUserData;
use AppBundle\Tests\AbstractFixtureAwareWebTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultControllerTest
 * @package AppBundle\Tests\Controller
 */
class CreateOauth2ClientFeatureTest extends AbstractFixtureAwareWebTestCase
{
    protected $purgeMode = ORMPurger::PURGE_MODE_DELETE;

    /**
     * @before
     */
    public function authenticate()
    {
        $form = $this->client->request('GET', '/login')->selectButton('Log in')->form();

        $this->client->followRedirects(true);
        $this->crawler = $this->client->submit($form, [
            '_username' => 'kentBeck',
            '_password' => 'pass',
        ]);

        $this->assertEquals('/', $this->client->getRequest()->getPathInfo());
        $this->assertNotRegExp('/Account is disabled./', $this->crawler->text());
        $this->client->followRedirects(false);
    }

    /**
     * @before
     */
    public function visitCreateOAuth2Client()
    {
        $this->crawler = $this->client->request('GET', '/oauth/v2/create_client');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
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
    public function shouldSeeProperHeader()
    {
        $this->assertEquals('Create OAuth2 Client', $this->crawler->filter('h1')->text());
    }

    /**
     * @test
     * @depends shouldAuthenticate
     */
    public function shouldSeeBackToHomepageLink()
    {
        $backToHomepageLink = $this->crawler->selectLink('Back to homepage');
        $this->assertCount(1, $backToHomepageLink);
        $this->assertEquals('/', $backToHomepageLink->attr('href'));
    }

    /**
     * @test
     * @depends shouldAuthenticate
     */
    public function shouldSeeFormWithRedirectUrlInputAndCreateSubmitButton()
    {
        $createBtn = $this->crawler->selectButton('Create');
        $this->assertCount(1, $createBtn);
        $this->assertCount(1, $this->crawler->filter('input[name="redirect_url"]'));
    }

    /**
     * @test
     * @depends shouldSeeFormWithRedirectUrlInputAndCreateSubmitButton
     */
    public function shouldCreateOauthClientIfFormHasBeenSubmitted()
    {
        $this->assertCount(0, $this->manager->getRepository('AppBundle:Client')->findAll());

        $form = $this->crawler->selectButton('Create')->form();
        $this->client->submit($form, [
            'redirect_url' => 'http://127.0.0.1:8000/callback',
        ]);

        $this->assertCount(1, $this->manager->getRepository('AppBundle:Client')->findAll());
        $this->assertTrue($this->client->getResponse()->isRedirection());
        $this->assertRegExp('#^/oauth/v2/auth#', $this->client->getResponse()->headers->get('location'));
    }

    /**
     * @test
     * @depends shouldCreateOauthClientIfFormHasBeenSubmitted
     */
    public function shouldRedirectToAllowOrDenyFormAfterCreatingOauthClient()
    {
        $this->createOAuthClient();

        $this->assertRegExp('#^/oauth/v2/auth#', $this->client->getRequest()->getPathInfo());

        $allowBtn = $this->crawler->filter('input[name="accepted"]');

        $this->assertCount(1, $allowBtn);
        $this->assertEquals('Allow', $allowBtn->attr('value'));

        $denyBtn = $this->crawler->filter('input[name="rejected"]');
        $this->assertCount(1, $denyBtn);
        $this->assertEquals('Deny', $denyBtn->attr('value'));
    }

    /**
     * @test
     * @depends shouldRedirectToAllowOrDenyFormAfterCreatingOauthClient
     */
    public function shouldRedirectToCallbackWithErrorAccessDeniedIfAuthorizingOauthClientRejected()
    {
        $this->createOAuthClient();

        $form = $this->crawler->selectButton('Deny')->form();
        $this->client->submit($form, [
            'rejected' => 'Deny',
        ]);
        $this->assertTrue($this->client->getResponse()->isRedirection());
        $this->assertRegExp('#^http://127.0.0.1:8000/callback\?error=access_denied.*#', $this->client->getResponse()->headers->get('location'));
    }

    /**
     * @test
     * @depends shouldRedirectToAllowOrDenyFormAfterCreatingOauthClient
     */
    public function shouldRedirectToCallbackWithAuthCodeTokenIfAuthorizingOauthClientAllowed()
    {
        $this->createOAuthClient();

        $this->assertCount(0, $this->manager->getRepository('AppBundle:AuthCode')->findAll());
        $form = $this->crawler->selectButton('Allow')->form();
        $this->client->submit($form, [
            'accepted' => 'Allow',
        ]);
        $this->assertTrue($this->client->getResponse()->isRedirection());

        $authCodes = $this->manager->getRepository('AppBundle:AuthCode')->findAll();
        $this->assertCount(1, $authCodes);

        $oAuthClientToken = $authCodes[0]->getToken();
        $this->assertEquals('http://127.0.0.1:8000/callback?state=&code='.$oAuthClientToken, $this->client->getResponse()->headers->get('location'));
    }

    /**
     * @test
     * @depends shouldRedirectToCallbackWithAuthCodeTokenIfAuthorizingOauthClientAllowed
     */
    public function shouldReturnAccessDeniedForOauthSecuredRouteIfNoTokenProvided()
    {
        $this->crawler = $this->client->request('GET', '/api/test');
        $this->assertEquals([
            'error' => 'access_denied',
            'error_description' => 'OAuth2 authentication required',
        ], json_decode($this->client->getResponse()->getContent(), true));
    }

    /**
     * @test
     * @depends shouldRedirectToCallbackWithAuthCodeTokenIfAuthorizingOauthClientAllowed
     */
    public function shouldReturnInvalidGrantForOauthSecuredRouteIfWrongTokenProvided()
    {
        $headers = [
            'HTTP_AUTHORIZATION' => 'Bearer ODgzZmZkZWM4MDhjZhE1NTljYTk4MjI5MTU2OWVjZjdmZTJiMzdhMTkxZmNlOGRhZWM0MzQ5N2I2OTI2YjllOA',
            'CONTENT_TYPE' => 'application/json',
        ];
        $this->crawler = $this->client->request('GET', '/api/test', [], [], $headers);
        $this->assertEquals([
            'error' => 'invalid_grant',
            'error_description' => 'The access token provided is invalid.',
        ], json_decode($this->client->getResponse()->getContent(), true));
    }

    /**
     * @test
     * @depends shouldReturnInvalidGrantForOauthSecuredRouteIfWrongTokenProvided
     */
    public function shouldAllowCreatingTokenUsingUsernameAndPasswordIfProperClientHasBeenCreated()
    {
        $responseJson = $this->createClientUsingEntityManagerAndCreateTokenUsingPostRequestWithUserCredentials();
        $this->assertTrue(array_key_exists('access_token', $responseJson));
    }

    /**
     * @test
     * @depends shouldAllowCreatingTokenUsingUsernameAndPasswordIfProperClientHasBeenCreated
     */
    public function shouldAllowAccessForOauthSecuredRouteIfLegitTokenProvided()
    {
        $responseJson = $this->createClientUsingEntityManagerAndCreateTokenUsingPostRequestWithUserCredentials();

        $headers = [
            'HTTP_AUTHORIZATION' => 'Bearer '.$responseJson['access_token'],
            'CONTENT_TYPE' => 'application/json',
        ];
        $this->crawler = $this->client->request('GET', '/api/test', [], [], $headers);

        $responseJson = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(['status' => 'accessGranted'], $responseJson);
    }

    protected function getFixtures()
    {
        return [new LoadUserData()];
    }

    protected function createOAuthClient()
    {
        $this->client->followRedirects(true);
        $form = $this->crawler->selectButton('Create')->form();
        $this->crawler = $this->client->submit($form, [
            'redirect_url' => 'http://127.0.0.1:8000/callback',
        ]);
        $this->client->followRedirects(false);
    }

    /**
     * @return mixed
     */
    protected function createClientUsingEntityManagerAndCreateTokenUsingPostRequestWithUserCredentials()
    {
        $clientManager = $this->client->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setAllowedGrantTypes(['token', 'password']);
        $clientManager->updateClient($client);

        $this->client->request('POST', '/oauth/v2/token', [
            'username' => 'kentBeck',
            'password' => 'pass',
            'grant_type' => 'password',
            'client_id' => $client->getPublicId(),
            'client_secret' => $client->getSecret(),
        ]);
        $responseJson = json_decode($this->client->getResponse()->getContent(), true);
        return $responseJson;
    }
}
