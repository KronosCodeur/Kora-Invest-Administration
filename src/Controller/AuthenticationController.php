<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    #[Route('/', name: 'adminLogin')]
    public function adminLogin(): Response
    {
        return $this->render('authentication/login.html.twig', [
        ]);
    }
    #[Route('/register', name: 'adminRegister')]
    public function adminRegister(): Response
    {
        return $this->render('authentication/register.html.twig', [
        ]);
    }
}
