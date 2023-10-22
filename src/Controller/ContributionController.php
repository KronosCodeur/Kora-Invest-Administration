<?php

namespace App\Controller;

use App\Repository\ContributionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContributionController extends AbstractController
{

    /**
     * @param ContributionRepository $contributionRepository
     */
    public function __construct(ContributionRepository $contributionRepository)
    {
        $this->contributionRepository = $contributionRepository;
    }

    #[Route('/admin/contributions', name: 'contribution.index')]
    public function index(): Response
    {
        $contributions = array_reverse($this->contributionRepository->findAll());
        return $this->render('contribution/index.html.twig', [
            'contributions' =>$contributions
        ]);
    }
    private  ContributionRepository $contributionRepository;
}
