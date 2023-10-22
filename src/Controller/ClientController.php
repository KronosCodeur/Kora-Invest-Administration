<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\User;
use App\Repository\CityRepository;
use App\Repository\InvestmentRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @param UserRepository $userRepository
     * @param CityRepository $cityRepository
     */
    public function __construct(UserRepository $userRepository, CityRepository $cityRepository)
    {
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
    }

    #[Route('/admin/clients', name: 'client.index')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();
        $clients = [];
        foreach ($users as $user) {
            if($user->getRoles()==["ROLE_CLIENT"]){
                $clients[] =$user;
            }
        }
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }
    private UserRepository $userRepository;

    #[Route('/admin/clients/addClient', name: 'client.addClient', methods: ["GET",'POST'])]
    public function addAdmin(Request $request,UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        if($request->isMethod("GET")){
            $cities = $this->cityRepository->findAll();
            return $this->render('client/add_client.html.twig',[
                "cities"=>$cities,
                "error"=>""
            ]);
        }else{
            $username = $request->get('username');
            if($userRepository->findOneBy(['username'=>$username])){
                $cities = $this->cityRepository->findAll();
                return $this->render('admin/add_admin.html.twig',[
                    "cities"=>$cities,
                    "error"=>"This username is already registered"
                ]);
            }
            $firstName = $request->get('firstName');
            $lastName = $request->get('lastName');
            $registeredAt = $request->get('dateRegistration');
            $phone = $request->get('phone');
            $gender = $request->get('gender');
            $cityId = $request->get('city');
            $city = $this->cityRepository->findOneBy(['id'=>$cityId]);
            $country = $city->getCountry();
            $picture = $request->files->get('picture');
            $address = $request->get('address');
            $birthday = $request->get('birthday');
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                $picture->move(
                    $this->getParameter('images_directory') . '/users/clients/profiles',
                    $newFilename
                );
            }
            $user = new  User();
            $user->setUsername($username);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setActive(false);
            $user->setBirthday($birthday);
            $user->setPlainPassword(null);
            $user->setAddress($address);
            $user->setCity($city);
            $user->setCountry($country);
            $user->setRegisteredAt($registeredAt);
            $user->setPhone($phone);
            if (!empty($newFilename)) {
                $user->setPicture("/pictures/users/clients/profiles/" . $newFilename);
            }
            $user->setRoles(["ROLE_CLIENT"]);
            try {
                $user->setInitialCode(random_int(100000, 999999));
            } catch (Exception $e) {
            }
            $user->setGender($gender);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('client.index');
        }
    }
    private  CityRepository $cityRepository;
    #[Route('/admin/clients/{id}', name: 'client.details',methods: ['GET'])]
    public function clientDetails( $id,TransactionRepository $transactionRepository,UserRepository $userRepository): Response
    {
        $client = $userRepository->findOneBy(['id'=>$id]);
        $transacs = $transactionRepository->findAll();
        $userTransactions = [];
        foreach ($transacs as $transac) {
            if($transac->getAccount()->getOwner() == $client){
                $userTransactions[] = $transac;
            }
        }
        return $this->render('client/client_details.html.twig', [
            'client' => $client,
            "clientTransactions"=>array_reverse($userTransactions)
        ]);
    }
}
