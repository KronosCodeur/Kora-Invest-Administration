<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvestmentController extends AbstractController
{
    #[Route('/investment', name: 'app_investment')]
    public function index(): Response
    {
        return $this->render('investment/index.html.twig', [
            'controller_name' => 'InvestmentController',
        ]);
    }
}
