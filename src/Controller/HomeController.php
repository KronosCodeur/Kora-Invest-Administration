<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route("/",name: "welcome",methods: ['GET'])]
    public function index(): Response
    {
        return $this->redirectToRoute('home.index');
    }
    #[Route("/admin",name: "home.index",methods: ['GET'])]
    public function home(): Response
    {
        $users = $this->userRepository->findBy(['roles'=>"ROLE_ADMIN"]);
        $count =0;
        foreach ($users as $user) {
            $roles[] = $user->getRoles;
            if ($roles)
            $count++;
        }
        return $this->render('home/index.html.twig',[
            "users"=>$count
        ]);
    }

    private UserRepository $userRepository;

}
