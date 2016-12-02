<?php

namespace AppBundle\Tests\Controller;

/**
 * Class EmployeeControllerActionEditId3Test
 * @package AppBundle\Tests\Controller
 */
class EmployeeControllerActionEditId3Test extends AbstractEmployeeControllerActionEditTest
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

        $this->assertEquals('Robert Cecil', $employeeName->attr('value'));
    }

    /**
     * @test
     * @depends shouldContainForm
     */
    public function formShouldContainEmployeeSurnameOfTypeTextBeingRequiredWithMaxLengthEqual64()
    {
        $employeeSurname = parent::formShouldContainEmployeeSurnameOfTypeTextBeingRequiredWithMaxLengthEqual64();

        $this->assertEquals('Martin', $employeeSurname->attr('value'));
    }

    /**
     * @test
     * @depends shouldContainForm
     */
    public function formShouldContainEmployeeEmailOfTypeEmailBeingBeingRequiredWithMaxLengthEqual254()
    {
        $employeeEmail = parent::formShouldContainEmployeeEmailOfTypeEmailBeingBeingRequiredWithMaxLengthEqual254();

        $this->assertEquals('robert.martin@fake.pl', $employeeEmail->attr('value'));
    }

    /**
     * @test
     * @depends shouldContainForm
     */
    public function formShouldContainEmployeeBioBeingNotRequiredTextAreaWithMaxLengthEqual400()
    {
        $employeeBio = parent::formShouldContainEmployeeBioBeingNotRequiredTextAreaWithMaxLengthEqual400();

        $this->assertEquals('An American software engineer and author. He is a co-author of the Agile Manifesto. He now runs a consulting firm called Clean Code.', $employeeBio->text());
    }

    /**
     * @test
     * @depends shouldContainForm
     */
    public function formShouldContainEmployeeDaysInOfficeBeingRequiredNumberWithMinEqual2AndMaxEqual5()
    {
        $employeeDaysInOffice = parent::formShouldContainEmployeeDaysInOfficeBeingRequiredNumberWithMinEqual2AndMaxEqual5();

        $this->assertEquals('4', $employeeDaysInOffice->attr('value'));
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return '/employee/3/edit';
    }
}
