<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends CRUDController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function disableAction(int $id): RedirectResponse
    {
        try {
            if (null === $object = $this->admin->getSubject()) {
                throw new NotFoundHttpException(sprintf('unable to find the user with id: %s', $id));
            }

            if ($object->isDisabled()) {
                throw new \RuntimeException(sprintf('already disabled user with id: %s', $id));
            }

            $object->disable();
            $this->entityManager->flush();

            $this->addFlash('sonata_flash_success', 'User disabled');
        } catch (NotFoundHttpException | \RuntimeException $exception) {
            $this->addFlash('sonata_flash_error', $exception->getMessage());
        }

        return new RedirectResponse($this->admin->generateUrl(
            'list',
            ['filter' => $this->admin->getFilterParameters()]
        ));
    }
}
