<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

/**
 * Class LoadUserData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadUserData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user0 = new User();
        $user0->setUsername('martinFowler');
        $user0->setEmail('martin.fowler@fake.pl');
        $user0->setPlainPassword('pass');

        $user1 = new User();
        $user1->setUsername('kentBeck');
        $user1->setEmail('kent.beck@fake.pl');
        $user1->setPlainPassword('pass');
        $user1->setEnabled(true);

        $user2 = new User();
        $user2->setUsername('robertCecilMartin');
        $user2->setEmail('robert.martin@fake.pl');
        $user2->setPlainPassword('pass');

        $manager->persist($user0);
        $manager->persist($user1);
        $manager->persist($user2);

        $manager->flush();
    }
}
