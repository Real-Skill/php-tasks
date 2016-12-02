<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AboutControllerTest
 * @package AppBundle\Tests\Controller
 */
class AboutControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function shouldDisplayProperHeadingAndStory()
    {
        $expectStory = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet assumenda distinctio incidunt inventore nulla omnis sit.';

        $client = static::createClient();
        $crawler = $client->request('GET', '/about');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('About', $crawler->filter('h1')->text());
        $this->assertContains($expectStory, $crawler->filter('.story')->text());
    }
}
