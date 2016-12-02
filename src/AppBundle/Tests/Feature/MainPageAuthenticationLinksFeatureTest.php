<?php

namespace AppBundle\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class DefaultControllerTest
 * @package AppBundle\Tests\Controller
 */
class MainPageAuthenticationLinksFeatureTest extends WebTestCase
{
    /**
     * @var  Client
     */
    protected $client;

    /**
     * @var  Crawler
     */
    protected $crawler;

    /**
     * @before
     */
    public function visitLoginPage()
    {
        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }


    /**
     * @test
     */
    public function shouldSeeRegisterLink()
    {
        $this->assertCount(1, $this->crawler->filter('#authentication a[href^="/register"]'));
    }

    /**
     * @test
     */
    public function shouldSeeLoginLink()
    {
        $this->assertCount(1, $this->crawler->filter('#authentication a[href^="/login"]'));
    }
}
