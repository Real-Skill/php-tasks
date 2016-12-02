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

    /**
     * @test
     */
    public function shouldDisplayListOfEmployeesNamesAsLinks()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/about');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $employeesList = $crawler->filter('.employees a');
        $this->assertCount(3, $employeesList);

        $expectEmployeesIdx = 0;
        $expectEmployees = [
            ['id' => 1, 'name' => 'Martin Fowler', 'bio' => 'A British software developer, author and international public speaker on software development, specializing in object-oriented analysis and design, UML, patterns, and agile software development methodologies, including extreme programming'],
            ['id' => 2, 'name' => 'Kent Beck', 'bio' => 'An American software engineer and the creator of extreme programming, a software development methodology which eschews rigid formal specification for a collaborative and iterative design process'],
            ['id' => 3, 'name' => 'Robert Cecil Martin', 'bio' => 'An American software engineer and author. He is a co-author of the Agile Manifesto. He now runs a consulting firm called Clean Code'],
        ];

        foreach ($employeesList as $employee) {
            /* @var \DOMElement $employee */
            $expectEmployee = &$expectEmployees[$expectEmployeesIdx++];
            $this->assertEquals($expectEmployee['name'], $employee->nodeValue);
            $this->assertEquals('/employee/'.$expectEmployee['id'], $employee->getAttribute('href'));
        }
    }
}
