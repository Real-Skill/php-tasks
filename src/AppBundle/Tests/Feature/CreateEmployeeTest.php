<?php

namespace AppBundle\Tests\Feature;

use AppBundle\Tests\AbstractFixtureAwareWebTestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @SuppressWarnings(TooManyPublicMethods)
 */
class CreateEmployeeTest extends AbstractFixtureAwareWebTestCase
{
    /**
     * @test
     */
    public function shouldNotSaveEmployeeWithAllFieldsEmptyAndDisplayProperInfo()
    {
        $form = $this->crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form, [
            'employee[name]' => '',
            'employee[surname]' => '',
            'employee[email]' => '',
            'employee[bio]' => '',
            'employee[daysInOffice]' => '',
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Should return OK(200) status code');
        $this->assertRegExp('#'.$this->getPath().'$#', $this->client->getHistory()->current()->getUri(), 'Should stay on "'.$this->getPath().'"');

        $formCrawler = $crawler->filter('form');

        $this->assertEquals('This value should not be blank.', $this->getValidationMessageForGivenFieldName($formCrawler, 'name'));
        $this->assertEquals('This value should not be blank.', $this->getValidationMessageForGivenFieldName($formCrawler, 'surname'));
        $this->assertEquals('This value should not be blank.', $this->getValidationMessageForGivenFieldName($formCrawler, 'email'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'bio'));
        $this->assertEquals('This value should not be blank.', $this->getValidationMessageForGivenFieldName($formCrawler, 'daysInOffice'));
    }

    /**
     * @test
     */
    public function shouldNotSaveEmployeeWithToShortName()
    {
        $form = $this->crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form, [
            'employee[name]' => 'aa',
            'employee[surname]' => 'aaa',
            'employee[email]' => 'test@test.pl',
            'employee[bio]' => '',
            'employee[daysInOffice]' => 3,
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Should return OK(200) status code');
        $this->assertRegExp('#'.$this->getPath().'$#', $this->client->getHistory()->current()->getUri(), 'Should stay on "'.$this->getPath().'"');

        $formCrawler = $crawler->filter('form');

        $this->assertEquals('This value is too short. It should have 3 characters or more.', $this->getValidationMessageForGivenFieldName($formCrawler, 'name'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'surname'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'email'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'bio'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'daysInOffice'));
    }

    /**
     * @test
     */
    public function shouldNotSaveEmployeeWithToLongName()
    {
        $form = $this->crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form, [
            'employee[name]' => str_repeat('a', 65),
            'employee[surname]' => 'aaa',
            'employee[email]' => 'test@test.pl',
            'employee[bio]' => '',
            'employee[daysInOffice]' => 3,
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Should return OK(200) status code');
        $this->assertRegExp('#'.$this->getPath().'$#', $this->client->getHistory()->current()->getUri(), 'Should stay on "'.$this->getPath().'"');

        $formCrawler = $crawler->filter('form');

        $this->assertEquals('This value is too long. It should have 64 characters or less.', $this->getValidationMessageForGivenFieldName($formCrawler, 'name'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'surname'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'email'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'bio'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'daysInOffice'));
    }

    /**
     * @test
     */
    public function shouldNotSaveEmployeeWithToShortSurname()
    {
        $form = $this->crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form, [
            'employee[name]' => 'aaa',
            'employee[surname]' => 'aa',
            'employee[email]' => 'test@test.pl',
            'employee[bio]' => '',
            'employee[daysInOffice]' => 3,
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Should return OK(200) status code');
        $this->assertRegExp('#'.$this->getPath().'$#', $this->client->getHistory()->current()->getUri(), 'Should stay on "'.$this->getPath().'"');

        $formCrawler = $crawler->filter('form');

        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'name'));
        $this->assertEquals('This value is too short. It should have 3 characters or more.', $this->getValidationMessageForGivenFieldName($formCrawler, 'surname'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'email'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'bio'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'daysInOffice'));
    }

    /**
     * @test
     */
    public function shouldNotSaveEmployeeWithToLongSurname()
    {
        $form = $this->crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form, [
            'employee[name]' => 'aaa',
            'employee[surname]' => str_repeat('a', 65),
            'employee[email]' => 'test@test.pl',
            'employee[bio]' => '',
            'employee[daysInOffice]' => 3,
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Should return OK(200) status code');
        $this->assertRegExp('#'.$this->getPath().'$#', $this->client->getHistory()->current()->getUri(), 'Should stay on "'.$this->getPath().'"');

        $formCrawler = $crawler->filter('form');

        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'name'));
        $this->assertEquals('This value is too long. It should have 64 characters or less.', $this->getValidationMessageForGivenFieldName($formCrawler, 'surname'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'email'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'bio'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'daysInOffice'));
    }

    /**
     * @test
     */
    public function shouldNotSaveEmployeeWithNotValidEmail()
    {
        $form = $this->crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form, [
            'employee[name]' => 'aaa',
            'employee[surname]' => 'aaa',
            'employee[email]' => 'test',
            'employee[bio]' => '',
            'employee[daysInOffice]' => 3,
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Should return OK(200) status code');
        $this->assertRegExp('#'.$this->getPath().'$#', $this->client->getHistory()->current()->getUri(), 'Should stay on "'.$this->getPath().'"');

        $formCrawler = $crawler->filter('form');

        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'name'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'surname'));
        $this->assertEquals('This value is not a valid email address.', $this->getValidationMessageForGivenFieldName($formCrawler, 'email'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'bio'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'daysInOffice'));
    }

    /**
     * @test
     */
    public function shouldNotSaveEmployeeWithToLongEmail()
    {
        $form = $this->crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form, [
            'employee[name]' => 'aaa',
            'employee[surname]' => 'aaa',
            'employee[email]' => str_repeat('a', 247).'@test.pl', //length: 255
            'employee[bio]' => '',
            'employee[daysInOffice]' => 3,
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Should return OK(200) status code');
        $this->assertRegExp('#'.$this->getPath().'$#', $this->client->getHistory()->current()->getUri(), 'Should stay on "'.$this->getPath().'"');

        $formCrawler = $crawler->filter('form');

        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'name'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'surname'));
        $this->assertEquals('This value is too long. It should have 254 characters or less.', $this->getValidationMessageForGivenFieldName($formCrawler, 'email'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'bio'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'daysInOffice'));
    }

    /**
     * @test
     */
    public function shouldNotSaveEmployeeWithToLongBio()
    {
        $form = $this->crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form, [
            'employee[name]' => 'aaa',
            'employee[surname]' => 'aaa',
            'employee[email]' => 'test@test.pl',
            'employee[bio]' => str_repeat('a', 401),
            'employee[daysInOffice]' => 3,
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Should return OK(200) status code');
        $this->assertRegExp('#'.$this->getPath().'$#', $this->client->getHistory()->current()->getUri(), 'Should stay on "'.$this->getPath().'"');

        $formCrawler = $crawler->filter('form');

        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'name'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'surname'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'email'));
        $this->assertEquals('This value is too long. It should have 400 characters or less.', $this->getValidationMessageForGivenFieldName($formCrawler, 'bio'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'daysInOffice'));
    }

    /**
     * @test
     */
    public function shouldNotSaveEmployeeWithInvalidTypeOfDaysInOffice()
    {
        $form = $this->crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form, [
            'employee[name]' => 'aaa',
            'employee[surname]' => 'aaa',
            'employee[email]' => 'test@test.pl',
            'employee[bio]' => '',
            'employee[daysInOffice]' => 'a',
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Should return OK(200) status code');
        $this->assertRegExp('#'.$this->getPath().'$#', $this->client->getHistory()->current()->getUri(), 'Should stay on "'.$this->getPath().'"');

        $formCrawler = $crawler->filter('form');

        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'name'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'surname'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'email'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'bio'));
        $this->assertEquals('This value is not valid.', $this->getValidationMessageForGivenFieldName($formCrawler, 'daysInOffice'));
    }

    /**
     * @test
     */
    public function shouldNotSaveEmployeeWithToLowValueOfDaysInOffice()
    {
        $form = $this->crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form, [
            'employee[name]' => 'aaa',
            'employee[surname]' => 'aaa',
            'employee[email]' => 'test@test.pl',
            'employee[bio]' => '',
            'employee[daysInOffice]' => 1,
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Should return OK(200) status code');
        $this->assertRegExp('#'.$this->getPath().'$#', $this->client->getHistory()->current()->getUri(), 'Should stay on "'.$this->getPath().'"');

        $formCrawler = $crawler->filter('form');

        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'name'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'surname'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'email'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'bio'));
        $this->assertEquals('You must be at least 2 days working in the office.', $this->getValidationMessageForGivenFieldName($formCrawler, 'daysInOffice'));
    }

    /**
     * @test
     */
    public function shouldNotSaveEmployeeWithToHighValueOfDaysInOffice()
    {
        $form = $this->crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form, [
            'employee[name]' => 'aaa',
            'employee[surname]' => 'aaa',
            'employee[email]' => 'test@test.pl',
            'employee[bio]' => '',
            'employee[daysInOffice]' => 6,
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Should return OK(200) status code');
        $this->assertRegExp('#'.$this->getPath().'$#', $this->client->getHistory()->current()->getUri(), 'Should stay on "'.$this->getPath().'"');

        $formCrawler = $crawler->filter('form');

        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'name'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'surname'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'email'));
        $this->assertEquals(null, $this->getValidationMessageForGivenFieldName($formCrawler, 'bio'));
        $this->assertEquals('You cannot work more than 5 days in the office.', $this->getValidationMessageForGivenFieldName($formCrawler, 'daysInOffice'));
    }

    /**
     * @test
     * @param int $count
     */
    public function shouldSaveEmployeeIfProperDataIsGivenAndRedirectToEmployeesList($count = 1)
    {
        $form = $this->crawler->selectButton('Save')->form();
        $formData = [
            'employee[name]' => str_repeat('a', 64),
            'employee[surname]' => str_repeat('a', 64),
            'employee[email]' => str_repeat('a', 246).'@test.pl', //length: 254
            'employee[bio]' => str_repeat('a', 400),
            'employee[daysInOffice]' => 5,
        ];
        $this->client->submit($form, $formData);

        $this->assertTrue($this->client->getResponse()->isRedirect('/employee'), 'Should redirect to "/emploee"');

        $crawler = $this->client->followRedirect();
        $employeeCrawler = $crawler->filter('.employee');

        $this->assertCount($count, $employeeCrawler);
        $this->assertEquals($formData['employee[name]'].' '.$formData['employee[surname]'], $employeeCrawler->filter('.name')->text());
        $this->assertEquals($formData['employee[email]'], $employeeCrawler->filter('.email')->text());
        $this->assertEquals($formData['employee[bio]'], $employeeCrawler->filter('.bio')->text());
        $this->assertEquals($formData['employee[daysInOffice]'], $employeeCrawler->filter('.daysInOffice')->text());
    }

    /**
     * @test
     * @param int $count
     */
    public function shouldNotRequireBio($count = 1)
    {
        $form = $this->crawler->selectButton('Save')->form();
        $formData = [
            'employee[name]' => str_repeat('a', 64),
            'employee[surname]' => str_repeat('a', 64),
            'employee[email]' => str_repeat('a', 246).'@test.pl', //length: 254
            'employee[bio]' => '',
            'employee[daysInOffice]' => 5,
        ];
        $this->client->submit($form, $formData);

        $this->assertTrue($this->client->getResponse()->isRedirect('/employee'), 'Should redirect to "/emploee"');

        $crawler = $this->client->followRedirect();
        $employeeCrawler = $crawler->filter('.employee');

        $this->assertCount($count, $employeeCrawler);
        $this->assertEquals($formData['employee[name]'].' '.$formData['employee[surname]'], $employeeCrawler->filter('.name')->text());
        $this->assertEquals($formData['employee[email]'], $employeeCrawler->filter('.email')->text());
        $this->assertEquals($formData['employee[bio]'], $employeeCrawler->filter('.bio')->text());
        $this->assertEquals($formData['employee[daysInOffice]'], $employeeCrawler->filter('.daysInOffice')->text());
    }

    /**
     * @return array
     */
    protected function getFixtures()
    {
        return [];
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return '/employee/new';
    }

    /**
     * @param Crawler $formCrawler
     * @param string  $fieldName
     * @return string
     */
    protected function getValidationMessageForGivenFieldName(Crawler $formCrawler, $fieldName)
    {
        $inputContainerCrawler = new Crawler($formCrawler->filter('[name="employee['.$fieldName.']"]')->parents()->html());
        $validationMessages = $inputContainerCrawler->filter('ul li');

        return $validationMessages->count() ? $validationMessages->text() : null;
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
