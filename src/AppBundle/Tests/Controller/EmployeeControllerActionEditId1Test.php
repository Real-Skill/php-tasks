<?php

namespace AppBundle\Tests\Controller;

/**
 * Class EmployeeControllerActionEditId1Test
 * @package AppBundle\Tests\Controller
 */
class EmployeeControllerActionEditId1Test extends AbstractEmployeeControllerActionEditTest
{
    /**
     * @test
     */
    public function shouldContainForm()
    {
        parent::shouldContainForm();
    }

    /**
     * @test
     * @depends shouldContainForm
     */
    public function formShouldContainEmployeeNameOfTypeTextBeingRequiredWithMaxLengthEqual64()
    {
        $employeeName = parent::formShouldContainEmployeeNameOfTypeTextBeingRequiredWithMaxLengthEqual64();

        $this->assertEquals('Martin', $employeeName->attr('value'));
    }

    /**
     * @test
     * @depends shouldContainForm
     */
    public function formShouldContainEmployeeSurnameOfTypeTextBeingRequiredWithMaxLengthEqual64()
    {
        $employeeSurname = parent::formShouldContainEmployeeSurnameOfTypeTextBeingRequiredWithMaxLengthEqual64();

        $this->assertEquals('Fowler', $employeeSurname->attr('value'));
    }

    /**
     * @test
     * @depends shouldContainForm
     */
    public function formShouldContainEmployeeEmailOfTypeEmailBeingBeingRequiredWithMaxLengthEqual254()
    {
        $employeeEmail = parent::formShouldContainEmployeeEmailOfTypeEmailBeingBeingRequiredWithMaxLengthEqual254();

        $this->assertEquals('martin.fowler@fake.pl', $employeeEmail->attr('value'));
    }

    /**
     * @test
     * @depends shouldContainForm
     */
    public function formShouldContainEmployeeBioBeingNotRequiredTextAreaWithMaxLengthEqual400()
    {
        $employeeBio = parent::formShouldContainEmployeeBioBeingNotRequiredTextAreaWithMaxLengthEqual400();

        $this->assertEquals('A British software developer, author and international public speaker on software development, specializing in object-oriented analysis and design, UML, patterns, and agile software development methodologies, including extreme programming.', $employeeBio->text());
    }

    /**
     * @test
     * @depends shouldContainForm
     */
    public function formShouldContainEmployeeDaysInOfficeBeingRequiredNumberWithMinEqual2AndMaxEqual5()
    {
        $employeeDaysInOffice = parent::formShouldContainEmployeeDaysInOfficeBeingRequiredNumberWithMinEqual2AndMaxEqual5();

        $this->assertEquals('2', $employeeDaysInOffice->attr('value'));
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return '/employee/1/edit';
    }
}
