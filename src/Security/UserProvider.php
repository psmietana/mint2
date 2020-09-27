<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadUserByUsername($email): User
    {
        $user = $this->findOneUserBy(['email' => $email]);

        if (!$user) {
            throw new UsernameNotFoundException(
                sprintf(
                    'User with "%s" email does not exist.',
                    $email
                )
            );
        }

        if ($user->isDisabled()) {
            throw new UsernameNotFoundException(
                sprintf(
                    'User with "%s" email is disabled.',
                    $email
                )
            );
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): User
    {
        assert($user instanceof User);

        if (null === $reloadedUser = $this->findOneUserBy(['id' => $user->getId()])) {
            throw new UsernameNotFoundException(sprintf(
                'User with ID "%s" could not be reloaded.',
                $user->getId()
            ));
        }

        return $reloadedUser;
    }

    public function supportsClass($class): bool
    {
        return $class === User::class;
    }

    private function findOneUserBy(array $options): ?User
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy($options);
    }
}
