<?php

namespace App\Controller;

use App\Repository\InvestmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvestmentController extends AbstractController
{
    /**
     * @param InvestmentRepository $investmentRepository
     */
    public function __construct(InvestmentRepository $investmentRepository)
    {
        $this->investmentRepository = $investmentRepository;
    }

    #[Route('/admin/investments', name: 'investment.index')]
    public function index(): Response
    {
        $investments = array_reverse($this->investmentRepository->findAll());
        return $this->render('investment/index.html.twig', [
            'investments' =>$investments
        ]);
    }
    private  InvestmentRepository $investmentRepository;
}
