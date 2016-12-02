<?php

namespace AppBundle\Tests\Controller;

use AppBundle\DataFixtures\ORM\LoadEmployeeData;
use AppBundle\Tests\AbstractFixtureAwareWebTestCase;

/**
 * Class AbstractEmployeeControllerActionEditTest
 * @package AppBundle\Tests\Controller
 */
abstract class AbstractEmployeeControllerActionEditTest extends AbstractFixtureAwareWebTestCase
{
    /**
     * @test
     */
    public function shouldContainButtonIndexWithProperLink()
    {
        $buttonIndex = $this->crawler->filter('.button.index');

        $this->assertCount(1, $buttonIndex);
        $this->assertEquals('/employee', $buttonIndex->attr('href'));
    }

    /**
     * @test
     */
    public function shouldContainForm()
    {
        $this->assertCount(1, $this->getForm());
    }

    /**
     * @test
     * @depends shouldContainForm
     *
     * @return string
     */
    public function formShouldContainEmployeeNameOfTypeTextBeingRequiredWithMaxLengthEqual64()
    {
        $form = $this->getForm();
        $employeeName = $form->filter('[name="employee[name]"]');

        $this->assertCount(1, $employeeName);
        $this->assertEquals('input', $employeeName->nodeName());
        $this->assertEquals('text', $employeeName->attr('type'));
        $this->assertNotNull($employeeName->attr('required'));
        $this->assertEquals(64, $employeeName->attr('maxlength'));

        return $employeeName;
    }

    /**
     * @test
     * @depends shouldContainForm
     * @return string
     */
    public function formShouldContainEmployeeSurnameOfTypeTextBeingRequiredWithMaxLengthEqual64()
    {
        $employeeSurname = $this->getForm()->filter('[name="employee[surname]"]');

        $this->assertCount(1, $employeeSurname);
        $this->assertEquals('input', $employeeSurname->nodeName());
        $this->assertEquals('text', $employeeSurname->attr('type'));
        $this->assertNotNull($employeeSurname->attr('required'));
        $this->assertEquals(64, $employeeSurname->attr('maxlength'));

        return $employeeSurname;
    }

    /**
     * @test
     * @depends shouldContainForm
     *
     * @return string
     */
    public function formShouldContainEmployeeEmailOfTypeEmailBeingBeingRequiredWithMaxLengthEqual254()
    {
        $employeeEmail = $this->getForm()->filter('[name="employee[email]"]');

        $this->assertCount(1, $employeeEmail);
        $this->assertEquals('input', $employeeEmail->nodeName());
        $this->assertEquals('email', $employeeEmail->attr('type'));
        $this->assertNotNull($employeeEmail->attr('required'));
        $this->assertEquals(254, $employeeEmail->attr('maxlength'));

        return $employeeEmail;
    }

    /**
     * @test
     * @depends shouldContainForm
     *
     * @return string
     */
    public function formShouldContainEmployeeBioBeingNotRequiredTextAreaWithMaxLengthEqual400()
    {
        $employeeBio = $this->getForm()->filter('[name="employee[bio]"]');

        $this->assertCount(1, $employeeBio);
        $this->assertEquals('textarea', $employeeBio->nodeName());
        $this->assertNull($employeeBio->attr('required'));
        $this->assertEquals(400, $employeeBio->attr('maxlength'));

        return $employeeBio;
    }

    /**
     * @test
     * @depends shouldContainForm
     *
     * @return int
     */
    public function formShouldContainEmployeeDaysInOfficeBeingRequiredNumberWithMinEqual2AndMaxEqual5()
    {
        $employeeDaysInOffice = $this->getForm()->filter('[name="employee[daysInOffice]"]');

        $this->assertCount(1, $employeeDaysInOffice);
        $this->assertEquals('input', $employeeDaysInOffice->nodeName());
        $this->assertEquals('number', $employeeDaysInOffice->attr('type'));
        $this->assertNotNull($employeeDaysInOffice->attr('required'));
        $this->assertEquals(2, $employeeDaysInOffice->attr('min'));
        $this->assertEquals(5, $employeeDaysInOffice->attr('max'));

        return $employeeDaysInOffice;
    }

    /**
     * @test
     * @depends shouldContainForm
     */
    public function formShouldContainAntiCsrfToken()
    {
        $employeeDaysInOffice = $this->getForm()->filter('[name="employee[_token]"]');

        $this->assertCount(1, $employeeDaysInOffice);
        $this->assertEquals('input', $employeeDaysInOffice->nodeName());
        $this->assertEquals('hidden', $employeeDaysInOffice->attr('type'));
    }

    /**
     * @test
     * @depends shouldContainForm
     */
    public function formShouldContainSaveButton()
    {
        $employeeDaysInOffice = $this->getForm()->filter('[name="employee[save]"]');

        $this->assertCount(1, $employeeDaysInOffice);
        $this->assertEquals('button', $employeeDaysInOffice->nodeName());
        $this->assertEquals('submit', $employeeDaysInOffice->attr('type'));
        $this->assertEquals('Save', $employeeDaysInOffice->text());
    }

    /**
     * @return string
     */
    abstract protected function getPath();

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
        $this->crawler = $this->client->request('GET', $this->getPath());

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function getForm()
    {
        return $this->crawler->filter('form[name=employee]');
    }
}
