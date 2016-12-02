<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class EmployeeManagerTest
 * @package AppBundle\Tests\Controller
 */
class EmployeeManagerTest extends KernelTestCase
{
    protected $employeeManager = null;

    /**
     * @test
     */
    public function shouldExists()
    {
        $this->assertNotNull($this->employeeManager);
    }

    /**
     * @test
     * @depends shouldExists
     */
    public function shouldHasMethodGetAll()
    {
        $this->assertTrue(method_exists($this->employeeManager, 'getAll'));
    }

    /**
     * @test
     * @depends shouldHasMethodGetAll
     */
    public function whenCalledGetAllItShouldReturnEmployeesArray()
    {
        $expectEmployees = [
            ['id' => 1, 'name' => 'Martin Fowler', 'bio' => 'A British software developer, author and international public speaker on software development, specializing in object-oriented analysis and design, UML, patterns, and agile software development methodologies, including extreme programming'],
            ['id' => 2, 'name' => 'Kent Beck', 'bio' => 'An American software engineer and the creator of extreme programming, a software development methodology which eschews rigid formal specification for a collaborative and iterative design process'],
            ['id' => 3, 'name' => 'Robert Cecil Martin', 'bio' => 'An American software engineer and author. He is a co-author of the Agile Manifesto. He now runs a consulting firm called Clean Code'],
        ];

        $this->assertTrue(method_exists($this->employeeManager, 'getAll'), 'employee.manager should has method getAll');
        $this->assertEquals($this->employeeManager->getAll(), $expectEmployees, 'method getAll of employee.manager should return employees array');
    }

    protected function setUp()
    {
        self::bootKernel();
        $this->employeeManager = static::$kernel->getContainer()->has('manager.employee') ? static::$kernel->getContainer()->get('manager.employee') : null;
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->employeeManager = null; // avoid memory leaks
    }
}
