<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    #[Route('/', name: 'app_authentication')]
    public function adminLogin(): Response
    {
        return $this->render('authentication/login.html.twig', [
        ]);
    }
}
