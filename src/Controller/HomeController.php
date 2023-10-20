<?php

namespace App\Controller;

use App\Repository\ContributionRepository;
use App\Repository\IncomeRepository;
use App\Repository\InvestmentRepository;
use App\Repository\UserRepository;
use App\Utils\DateTimeUtils;
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
     * @param DateTimeUtils $dateTimeUtils
     */
    public function __construct(UserRepository $userRepository, ContributionRepository $contributionRepository, IncomeRepository $incomeRepository, InvestmentRepository $investmentRepository, DateTimeUtils $dateTimeUtils)
    {
        $this->userRepository = $userRepository;
        $this->contributionRepository = $contributionRepository;
        $this->incomeRepository = $incomeRepository;
        $this->investmentRepository = $investmentRepository;
        $this->dateTimeUtils = $dateTimeUtils;
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
        $dailyContributions =0;
        foreach ($contributions as $contribution) {
            if($this->dateTimeUtils->dateIsNow($contribution->getMakedAt(),format: 'Y-m-d')){
                $dailyContributions++;
            }
        }
        $investments = $this->investmentRepository->findBy(['blocked'=>true]);
        $dailyInvestment = 0;
        foreach ($investments as $investment) {
            if($this->dateTimeUtils->dateIsNow($investment->getMakedAt(),format: 'Y-m-d')){
                $dailyInvestment++;
            }
        }
        $dailyIncomesAmount = 0;
        $incomes = $this->incomeRepository->findAll();
        foreach ($incomes as $income) {
            if($this->dateTimeUtils->dateIsNow(substr($income->getMakedAt(),0,10),"Y-m-d")){
                $dailyIncomesAmount += $income->getAmount();
            }
        }
        $count =0;
        foreach ($users as $user) {
            if ($user->getRoles()===["ROLE_CLIENT"] && $this->dateTimeUtils->dateIsNow($user->getRegisteredAt(),format: 'Y-m-d') )
            $count++;
        }
        return $this->render('home/index.html.twig',[
            "users"=>$users,
            "clients"=>$count,
            "dailyIncomes"=>$dailyIncomesAmount,
            "contributions"=>$dailyContributions,
            "investments"=>$dailyInvestment
        ]);
    }

    private UserRepository $userRepository;
    private  ContributionRepository  $contributionRepository;
    private  IncomeRepository $incomeRepository;
    private  InvestmentRepository $investmentRepository;
    private  DateTimeUtils $dateTimeUtils;

}
