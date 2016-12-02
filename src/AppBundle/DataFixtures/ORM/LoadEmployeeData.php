<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Employee;

/**
 * Class LoadEmployeeData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadEmployeeData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $employee0 = new Employee();
        $employee0->setName('Martin');
        $employee0->setSurname('Fowler');
        $employee0->setEmail('martin.fowler@fake.pl');
        $employee0->setDaysInOffice(2);
        $employee0->setBio('A British software developer, author and international public speaker on software development, specializing in object-oriented analysis and design, UML, patterns, and agile software development methodologies, including extreme programming.');

        $employee1 = new Employee();
        $employee1->setName('Kent');
        $employee1->setSurname('Beck');
        $employee1->setEmail('kent.beck@fake.pl');
        $employee1->setDaysInOffice(5);
        $employee1->setBio('An American software engineer and the creator of extreme programming, a software development methodology which eschews rigid formal specification for a collaborative and iterative design process.');

        $employee2 = new Employee();
        $employee2->setName('Robert Cecil');
        $employee2->setSurname('Martin');
        $employee2->setEmail('robert.martin@fake.pl');
        $employee2->setDaysInOffice(4);
        $employee2->setBio('An American software engineer and author. He is a co-author of the Agile Manifesto. He now runs a consulting firm called Clean Code.');

        $manager->persist($employee0);
        $manager->persist($employee1);
        $manager->persist($employee2);

        $manager->flush();
    }
}
