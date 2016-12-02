<?php

namespace AppBundle\Tests\Entity;

use AppBundle\DataFixtures\ORM\LoadEmployeeData;
use AppBundle\Entity\Employee;
use AppBundle\Tests\AbstractFixtureAwareTestCase;

/**
 * Class EmployeeTest
 * @package AppBundle\Tests\Entity
 */
class EmployeeTest extends AbstractFixtureAwareTestCase
{
    /**
     * @test
     * @expectedException Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function shouldNotAllowToSaveEmployeeWithoutName()
    {
        $employee = new Employee();
        $employee
            ->setSurname('aaa')
            ->setEmail('test@test.pl')
            ->setDaysInOffice(3);

        $em = self::getEntityManager();

        $em->persist($employee);
        $em->flush();
    }

    /**
     * @test
     * @expectedException Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function shouldNotAllowToSaveEmployeeWithoutSurname()
    {
        $employee = new Employee();
        $employee
            ->setName('aaa')
            ->setEmail('test@test.pl')
            ->setDaysInOffice(3);

        $em = self::getEntityManager();

        $em->persist($employee);
        $em->flush();
    }

    /**
     * @test
     * @expectedException Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function shouldNotAllowToSaveEmployeeWithoutEmail()
    {
        $employee = new Employee();
        $employee
            ->setName('aaa')
            ->setSurname('aaa')
            ->setDaysInOffice(3);

        $em = self::getEntityManager();

        $em->persist($employee);
        $em->flush();
    }

    /**
     * @test
     * @expectedException Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function shouldNotAllowToSaveEmployeeWithoutDaysInOffice()
    {
        $employee = new Employee();
        $employee
            ->setName('aaa')
            ->setSurname('aaa')
            ->setEmail('test@test.pl');

        $em = self::getEntityManager();

        $em->persist($employee);
        $em->flush();
    }

    /**
     * @test
     * @expectedException Doctrine\DBAL\Exception\UniqueConstraintViolationException
     */
    public function shouldNotAllowToSaveEmployeeWithSameEmailThatExistsInDb()
    {
        $employee = new Employee();
        $employee
            ->setName('aaa')
            ->setSurname('aaa')
            ->setEmail('martin.fowler@fake.pl')
            ->setDaysInOffice(3);

        $em = self::getEntityManager();

        $em->persist($employee);
        $em->flush();
    }

    /**
     * @test
     */
    public function shouldAllowToSaveEmployeeWithoutBio()
    {
        $employee = new Employee();
        $employee
            ->setName(str_repeat('a', 64))
            ->setSurname(str_repeat('a', 64))
            ->setEmail(str_repeat('a', 254))
            ->setDaysInOffice(3);

        $em = self::getEntityManager();

        $em->persist($employee);
        $em->flush();
        $em->detach($employee);

        /**
         * @var Employee $savedEmployee
         */
        $savedEmployee = $em->getRepository('AppBundle:Employee')->find(4);

        $this->assertEquals(64, strlen($savedEmployee->getName()));
        $this->assertEquals(64, strlen($savedEmployee->getSurname()));
        $this->assertEquals(254, strlen($savedEmployee->getEmail()));
        $this->assertEquals(0, strlen($savedEmployee->getBio()));
        $this->assertEquals(3, $savedEmployee->getDaysInOffice());
    }

    /**
     * @test
     */
    public function shouldHaveDefinedLengthOfEachStringFieldAndTrimIfIsLonger()
    {
        $employee = new Employee();
        $employee
            ->setName(str_repeat('a', 999))
            ->setSurname(str_repeat('a', 999))
            ->setEmail(str_repeat('a', 999))
            ->setBio(str_repeat('a', 999))
            ->setDaysInOffice(3);

        $em = self::getEntityManager();

        $em->persist($employee);
        $em->flush();
        $em->detach($employee);

        /**
         * @var Employee $savedEmployee
         */
        $savedEmployee = $em->getRepository('AppBundle:Employee')->find(4);

        $this->assertEquals(64, strlen($savedEmployee->getName()), 'Name should has max length equal 64');
        $this->assertEquals(64, strlen($savedEmployee->getSurname()), 'Surname should has max length equal 64');
        $this->assertEquals(254, strlen($savedEmployee->getEmail()), 'Email should has max length equal 254');
        $this->assertEquals(400, strlen($savedEmployee->getBio()), 'Bio should has max length equal 400');
        $this->assertEquals(3, $savedEmployee->getDaysInOffice());
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected static function getEntityManager()
    {
        return self::$kernel->getContainer()->get('doctrine')->getManager();
    }

    /**
     * @before
     */
    protected function loadFixtures()
    {
        $this->executeFixtures([new LoadEmployeeData()]);
    }
}
