<?php

namespace AppBundle\Tests\Controller;

use AppBundle\DataFixtures\ORM\LoadEmployeeData;
use AppBundle\Tests\AbstractFixtureAwareWebTestCase;

/**
 * Class EmployeeWebTestCaseActionIndexTest
 * @package AppBundle\Tests\Controller
 */
class EmployeeWebTestCaseActionIndexTest extends AbstractFixtureAwareWebTestCase
{
    /**
     * @test
     */
    public function shouldContainEmployeesHeading()
    {
        $heading = $this->crawler->filter('h1');

        $this->assertCount(1, $heading);
        $this->assertContains('Employees', $heading->text());
    }

    /**
     * @test
     */
    public function shouldContainAddNewButtonWithProperLink()
    {
        $buttonNew = $this->crawler->filter('.button.new');

        $this->assertCount(1, $buttonNew);
        $this->assertContains('Add new', $buttonNew->text());
        $this->assertContains('/employee/new', $buttonNew->attr('href'));
    }

    /**
     * @test
     */
    public function shouldContainEmployeesListed()
    {
        $employees = $this->crawler->filter('.employees .employee');

        $this->assertCount(3, $employees);

        $employee0 = $employees->eq(0);
        $employee1 = $employees->eq(1);
        $employee2 = $employees->eq(2);

        $this->assertEquals('Martin Fowler', $employee0->filter('.name')->text());
        $this->assertEquals('martin.fowler@fake.pl', $employee0->filter('.email')->text());
        $this->assertEquals('2', $employee0->filter('.daysInOffice')->text());
        $this->assertEquals('A British software developer, author and international public speaker on software development, specializing in object-oriented analysis and design, UML, patterns, and agile software development methodologies, including extreme programming.', $employee0->filter('.bio')->text());

        $this->assertEquals('Kent Beck', $employee1->filter('.name')->text());
        $this->assertEquals('kent.beck@fake.pl', $employee1->filter('.email')->text());
        $this->assertEquals('5', $employee1->filter('.daysInOffice')->text());
        $this->assertEquals('An American software engineer and the creator of extreme programming, a software development methodology which eschews rigid formal specification for a collaborative and iterative design process.', $employee1->filter('.bio')->text());

        $this->assertEquals('Robert Cecil Martin', $employee2->filter('.name')->text());
        $this->assertEquals('robert.martin@fake.pl', $employee2->filter('.email')->text());
        $this->assertEquals('4', $employee2->filter('.daysInOffice')->text());
        $this->assertEquals('An American software engineer and author. He is a co-author of the Agile Manifesto. He now runs a consulting firm called Clean Code.', $employee2->filter('.bio')->text());
    }

    /**
     * @test
     * @depends shouldContainEmployeesListed
     */
    public function eachListedEmployeeShouldContainEditAndDeleteButtonsWithProperLinks()
    {
        $employees = $this->crawler->filter('.employees .employee');

        $employee0 = $employees->eq(0);
        $employee1 = $employees->eq(1);
        $employee2 = $employees->eq(2);

        $employee0ButtonEdit = $employee0->filter('.button.edit');
        $employee0ButtonDelete = $employee0->filter('.button.delete');
        $employee1ButtonEdit = $employee1->filter('.button.edit');
        $employee1ButtonDelete = $employee1->filter('.button.delete');
        $employee2ButtonEdit = $employee2->filter('.button.edit');
        $employee2ButtonDelete = $employee2->filter('.button.delete');

        $this->assertEquals('Edit', $employee0ButtonEdit->text());
        $this->assertEquals('/employee/1/edit', $employee0ButtonEdit->attr('href'));
        $this->assertEquals('Delete', $employee0ButtonDelete->text());
        $this->assertEquals('/employee/1/delete', $employee0ButtonDelete->attr('href'));

        $this->assertEquals('Edit', $employee1ButtonEdit->text());
        $this->assertEquals('/employee/2/edit', $employee1ButtonEdit->attr('href'));
        $this->assertEquals('Delete', $employee1ButtonDelete->text());
        $this->assertEquals('/employee/2/delete', $employee1ButtonDelete->attr('href'));

        $this->assertEquals('Edit', $employee2ButtonEdit->text());
        $this->assertEquals('/employee/3/edit', $employee2ButtonEdit->attr('href'));
        $this->assertEquals('Delete', $employee2ButtonDelete->text());
        $this->assertEquals('/employee/3/delete', $employee2ButtonDelete->attr('href'));
    }

    /**
     * @return array
     */
    protected function getFixtures()
    {
        return [new LoadEmployeeData()];
    }

    /**
     * @before
     */
    protected function doGetRequestAndAssertOkStatusCode()
    {
        $this->crawler = $this->client->request('GET', '/employee');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
