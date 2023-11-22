<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CityRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Utils\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @param UserRepository $userRepository
     * @param CityRepository $cityRepository
     * @param TokenGenerator $tokenGenerator
     */
    public function __construct(UserRepository $userRepository, CityRepository $cityRepository, TokenGenerator $tokenGenerator)
    {
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
        $this->tokenGenerator = $tokenGenerator;
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
    private  TokenGenerator $tokenGenerator;

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

    #[Route('/api/activeClientAccount', name: 'client.activeAccount',methods: ['POST'])]
    public function activateAccount(Request $request,UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $data = json_decode( $request->getContent(),true);
        $phone = $data['phone'];
        $code = $data['code'];
        $password = $data['password'];
        $user = $userRepository->findOneBy(['phone'=>$phone,'initialCode'=>$code]);
        if($user==null  && $user->getRoles() != ['ROLE_CLIENT']){
            $jsonData = json_encode([
                "success"=>false,
                "message"=>"Utilisateur non trouvee"
            ]);
            return new JsonResponse($jsonData,Response::HTTP_NOT_FOUND,[],true);
        }
        $user->setPlainPassword($password);
        $user->setUsername($phone);
        try {
            $user->setInitialCode(random_int(100000, 999999));
        } catch (Exception $e) {
        }
        $entityManager->persist($user);
        $entityManager->flush();
        $jsonData = json_encode([
            "success"=>true,
            "message"=>"Compte activee  avec success"
        ]);
        return new JsonResponse($jsonData,Response::HTTP_OK,[],true);
    }
    #[Route('/api/clientLogin', name: 'client.login',methods: ['POST'])]
    public function clientLogin(Request $request,UserRepository $userRepository,EntityManagerInterface $entityManager, UserPasswordHasherInterface  $passwordHasher)
    {
        $data = json_decode( $request->getContent(),true);
        $phone = $data['phone'];
        $password = $data['password'];
        $user = $userRepository->findOneBy(['username'=>$phone]);
        if($user===null){
            $jsonData = json_encode([
                "success"=>false,
                "message"=>"Utilisateur non trouvee"
            ]);
            return new JsonResponse($jsonData,Response::HTTP_NOT_FOUND,[],true);
        }
        $verify = $passwordHasher->isPasswordValid($user,$password);
        if(!$verify){
            $jsonData = json_encode([
                "success"=>false,
                "message"=>"Veuillez verifier  votre  mot de passe "
            ]);
            return new JsonResponse($jsonData,Response::HTTP_NOT_FOUND,[],true);
        }
        $accessToken =$this->tokenGenerator->generateToken($user);
        $user->setToken($accessToken);
        $user->setPlainPassword($password);
        $entityManager->persist($user);
        $entityManager->flush();
        $jsonData = json_encode([
            "success"=>true,
            "message"=>"Bienvenue sur Kora Invest ".$user->getFirstName()." ".$user->getLastName(),
            "accessToken"=>$user->getToken(),
            "userInfo"=>[
                "id"=>$user->getId(),
                "userName"=>$user->getUsername(),
                "name"=>$user->getLastName()." ".$user->getFirstName(),
                "phone"=>$user->getPhone(),
                "address"=>$user->getAddress(),
                "birthday"=>$user->getBirthday(),
                "picture"=>$user->getPicture(),
                "gender"=>$user->getGender()=="male"?"Masculin":"Feminin",
            ]
        ]);
        return new JsonResponse($jsonData,Response::HTTP_OK,[],true);
    }
}
