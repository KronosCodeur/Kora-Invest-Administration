<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/admin/clients', name: 'clients.index')]
    public function index(): Response
    {
        $clients = $this->userRepository->findAll();
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }
    private UserRepository $userRepository;

}
