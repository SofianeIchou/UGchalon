<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        // Cette page appellera la vue templates/main/home.html.twig
        return $this->render('main/home.html.twig');
    }

}


