<?php

namespace App\Controller;

use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @param AccountRepository $accountRepository
     */
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    #[Route('/admin/account', name: 'account.index')]
    public function index(): Response
    {
        $accounts = $this->accountRepository->findAll();
        return $this->render('account/index.html.twig', [
            'accounts' => $accounts,
        ]);
    }
    private  AccountRepository $accountRepository;
}
