<?php

namespace App\Controller;

use App\Repository\ContributionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    /**
     * @param UserRepository $userRepository
     * @param ContributionRepository $contributionRepository
     */
    public function __construct(UserRepository $userRepository, ContributionRepository $contributionRepository)
    {
        $this->userRepository = $userRepository;
        $this->contributionRepository = $contributionRepository;
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
        $count =0;
        foreach ($users as $user) {

            if ($user->getRoles()===["ROLE_ADMIN"])
            $count++;
        }
        return $this->render('home/index.html.twig',[
            "users"=>$users,
            "clients"=>$count,
            "contributions"=>$contributions
        ]);
    }

    private UserRepository $userRepository;
    private  ContributionRepository  $contributionRepository;

}
