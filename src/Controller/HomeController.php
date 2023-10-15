<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route("/",name: "welcome",methods: ['GET'])]
    public function index(): Response
    {
        return $this->redirectToRoute('home.index');
    }
    #[Route("/admin",name: "home.index",methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('home/index.html.twig');
    }
}
