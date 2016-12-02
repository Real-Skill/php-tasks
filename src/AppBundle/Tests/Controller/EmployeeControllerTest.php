<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class EmployeeControllerTest
 * @package AppBundle\Tests\Controller
 */
class EmployeeControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function shouldReturn404IfNoSuchEmployee()
    {
        $client = self::createClient();
        $client->request('GET', '/employee/0');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldDisplayEmployeeNameAndBio()
    {
        $expectEmployees = [
            ['id' => 1, 'name' => 'Martin Fowler', 'bio' => 'A British software developer, author and international public speaker on software development, specializing in object-oriented analysis and design, UML, patterns, and agile software development methodologies, including extreme programming'],
            ['id' => 2, 'name' => 'Kent Beck', 'bio' => 'An American software engineer and the creator of extreme programming, a software development methodology which eschews rigid formal specification for a collaborative and iterative design process'],
            ['id' => 3, 'name' => 'Robert Cecil Martin', 'bio' => 'An American software engineer and author. He is a co-author of the Agile Manifesto. He now runs a consulting firm called Clean Code'],
        ];

        $client = self::createClient();

        foreach ($expectEmployees as $expectEmployee) {
            $crawler = $client->request('GET', '/employee/'.$expectEmployee['id']);
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
            $this->assertEquals($expectEmployee['name'], $crawler->filter('h1')->text());
            $this->assertEquals($expectEmployee['bio'], $crawler->filter('.bio')->text());
        }
    }
}
