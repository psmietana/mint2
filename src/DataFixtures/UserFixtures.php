<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $totalUsersNumber = rand(30, 50);
        for ($i = 1; $i <= $totalUsersNumber; $i++) {
            $user = new User();

            $name = 'test' . $i;
            $password = $this->userPasswordEncoder->encodePassword($user, $name);
            $user->setEmail($name . '@test.com');
            $user->setPassword($password);
            $user->setRoles(['ROLE_ADMIN']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
