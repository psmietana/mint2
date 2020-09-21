<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function indexAction()
    {
        return $this->redirectToRoute(null === $this->getUser()
            ? 'app_login'
            : 'sonata_admin_dashboard'
        );
    }
}
