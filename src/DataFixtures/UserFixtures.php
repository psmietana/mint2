<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $totalUsersNumber = rand(30, 50);
        for ($i = 1; $i <= $totalUsersNumber; $i++) {
            $name = 'test' . $i;
            $user = new User();
            $user->setEmail($name . '@test.com');
            $user->setPassword($name);
            $user->setRoles(['ROLE_ADMIN']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
