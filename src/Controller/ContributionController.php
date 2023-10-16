<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContributionController extends AbstractController
{
    #[Route('/contribution', name: 'app_contribution')]
    public function index(): Response
    {
        return $this->render('contribution/index.html.twig', [
            'controller_name' => 'ContributionController',
        ]);
    }
}
