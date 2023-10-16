<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/error/access_denied', name: 'error.accessDenied')]
    public function accessDenied(): Response
    {
        return $this->render('error/access_denied.html.twig');
    }
}
