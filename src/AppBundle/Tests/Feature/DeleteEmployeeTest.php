<?php

namespace AppBundle\Tests\Feature;

use AppBundle\DataFixtures\ORM\LoadEmployeeData;
use AppBundle\Tests\AbstractFixtureAwareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DeleteEmployeeTest
 * @package AppBundle\Tests\Feature
 */
class DeleteEmployeeTest extends AbstractFixtureAwareWebTestCase
{
    /**
     * @test
     */
    public function shouldReturn404IfEmployeeWithGivenEmployeeIdNotExist()
    {
        $this->client->request('GET', '/employee/4/delete');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldDeleteCertainEmployeeAndRedirectToEmployeesList()
    {
        $employeesCrawler = $this->crawler->filter('.employee');
        $this->assertCount(3, $employeesCrawler);

        $secondEmployee = $employeesCrawler->eq(1);
        $this->assertEquals('Kent Beck', $secondEmployee->filter('.name')->text());

        $this->crawler = $this->client->request('GET', $secondEmployee->selectLink('Delete')->link()->getUri());
        $this->assertTrue($this->client->getResponse()->isRedirect('/employee'), 'Should redirect to "/employee"');

        $this->crawler = $this->client->followRedirect();
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertRegExp('#/employee$#', $this->client->getHistory()->current()->getUri(), 'Should redirect to "/employee"');

        $employeesCrawler = $this->crawler->filter('.employee');
        $this->assertCount(2, $employeesCrawler);

        $secondEmployee = $employeesCrawler->eq(1);
        $this->assertEquals('Robert Cecil Martin', $secondEmployee->filter('.name')->text());
    }


    /**
     * @return array
     */
    protected function getFixtures()
    {
        return [new LoadEmployeeData()];
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return '/employee';
    }

    /**
     * @before
     */
    protected function getRequestAndAssertStatusCodeEquals200()
    {
        $this->crawler = $this->client->request('GET', $this->getPath());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Should return OK(200) status code');
    }
}
