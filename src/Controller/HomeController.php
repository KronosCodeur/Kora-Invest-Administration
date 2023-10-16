<?php

namespace App\Controller;

use App\Repository\ContributionRepository;
use App\Repository\IncomeRepository;
use App\Repository\InvestmentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    /**
     * @param UserRepository $userRepository
     * @param ContributionRepository $contributionRepository
     * @param IncomeRepository $incomeRepository
     * @param InvestmentRepository $investmentRepository
     */
    public function __construct(UserRepository $userRepository, ContributionRepository $contributionRepository, IncomeRepository $incomeRepository, InvestmentRepository $investmentRepository)
    {
        $this->userRepository = $userRepository;
        $this->contributionRepository = $contributionRepository;
        $this->incomeRepository = $incomeRepository;
        $this->investmentRepository = $investmentRepository;
    }

    #[Route("/",name: "welcome",methods: ['GET'])]
    public function index(): Response
    {
        return $this->redirectToRoute('home.index');
    }
    #[Route("/admin",name: "home.index",methods: ['GET'])]
    public function home(): Response
    {
        $users = $this->userRepository->findAll();
        $contributions = $this->contributionRepository->findAll();
        $investments = $this->investmentRepository->findBy(['blocked'=>true]);
        $dailyIncomesAmount = 0;
        $incomes = $this->incomeRepository->findAll();
        foreach ($incomes as $income) {
            $dailyIncomesAmount += $income->getAmount();
        }
        $count =0;
        foreach ($users as $user) {
            if ($user->getRoles()===["ROLE_CLIENT"])
            $count++;
        }
        return $this->render('home/index.html.twig',[
            "users"=>$users,
            "clients"=>$count,
            "dailyIncomes"=>$dailyIncomesAmount,
            "contributions"=>$contributions,
            "investments"=>$investments
        ]);
    }

    private UserRepository $userRepository;
    private  ContributionRepository  $contributionRepository;
    private  IncomeRepository $incomeRepository;
    private  InvestmentRepository $investmentRepository;

}
