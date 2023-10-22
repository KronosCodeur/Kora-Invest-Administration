<?php

namespace App\Controller;

use App\Entity\Account;
use App\Repository\AccountRepository;
use App\Repository\AccountTypeRepository;
use App\Repository\UserRepository;
use App\Utils\AccountNumberUtils;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    private AccountRepository $accountRepository;
    private UserRepository $userRepository;
    private AccountTypeRepository $accountTypeRepository;
    private AccountNumberUtils $accountNumberUtils;

    /**
     * @param AccountRepository $accountRepository
     * @param UserRepository $userRepository
     * @param AccountTypeRepository $accountTypeRepository
     * @param AccountNumberUtils $accountNumberUtils
     */
    public function __construct(AccountRepository $accountRepository, UserRepository $userRepository, AccountTypeRepository $accountTypeRepository, AccountNumberUtils $accountNumberUtils)
    {
        $this->accountRepository = $accountRepository;
        $this->userRepository = $userRepository;
        $this->accountTypeRepository = $accountTypeRepository;
        $this->accountNumberUtils = $accountNumberUtils;
    }

    #[Route('/admin/account', name: 'account.index')]
    public function index(): Response
    {
        $accounts = $this->accountRepository->findAll();
        return $this->render('account/index.html.twig', [
            'accounts' => $accounts,
        ]);
    }

    #[Route('/admin/account/createAccount', name: 'account.createAccount',methods: ['POST','GET'])]
    public function createAccount(Request $request, EntityManagerInterface $entityManager): Response
    {
        if($request->isMethod('GET')) {
            $accountNumber = $this->accountNumberUtils->generateAccountNumber();
            $types = $this->accountTypeRepository->findAll();
            $users = $this->userRepository->findAll();
            $clients = [];
            foreach ($users as $user) {
                if ($user->getRoles() == ["ROLE_CLIENT"]) {
                    $clients[] = $user;
                }
            }
            return $this->render('account/create_account.html.twig', [
                "accountNumber" => $accountNumber,
                "types" => $types,
                'clients' => $clients
            ]);
        }else{
            $number = $request->get('number');
            $type= $request->get('type');
            $owner = $request->get('client');
            $date = str_replace("T"," ",$request->get('date'));
            $account = new Account();
            $account->setOwner($this->userRepository->findOneBy(['id'=>$owner]));
            $account->setType($this->accountTypeRepository->findOneBy(['id'=>$type]));
            $account->setActive(true);
            $account->setSolde(0);
            $account->setCreatedAt($date);
            $account->setNumber($number);
            $entityManager->persist($account);
            $entityManager->flush();
            return $this->redirectToRoute('account.index');
        }
    }
}
