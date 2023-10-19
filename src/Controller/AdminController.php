<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CityRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{


    /**
     * @param UserRepository $userRepository
     * @param CityRepository $cityRepository
     */
    public function __construct(UserRepository $userRepository ,CityRepository $cityRepository)
    {
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
    }

    #[Route('/superAdmin', name: 'admin.index')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();
        $admins = [];
        $removedAdmins = [];
        $superAdmins = [];
        foreach ($users as $user) {
            if($user->getRoles()==["ROLE_ADMIN"]){
                $admins[] =$user;
            }elseif ($user->getRoles()==["ROLE_SUPER_ADMIN"]){
                $superAdmins[] = $user;
            }elseif ($user->getRoles()==["ROLE_REMOVED"]){
                $removedAdmins[] = $user;
            }
        }
        return $this->render('admin/index.html.twig', [
            'admins' => $admins,
            'superAdmins' => $superAdmins,
            'removedAdmins' => $removedAdmins,
        ]);
    }
    private  UserRepository $userRepository;

    #[Route('/superAdmin/addAdmin', name: 'admin.addAdmin', methods: ["GET",'POST'])]
    public function addAdmin(Request $request,UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        if($request->isMethod("GET")){
            $cities = $this->cityRepository->findAll();
            return $this->render('admin/add_admin.html.twig',[
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
            $city_id = $request->get('city');
            $city = $this->cityRepository->findOneBy(['id'=>$city_id]);
            $picture = $request->files->get('picture');
            $address = $request->get('address');
            $birthday = $request->get('birthday');
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                $picture->move(
                    $this->getParameter('images_directory') . '/users/admins/profiles',
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
            $user->setRegisteredAt($registeredAt);
            $user->setPhone($phone);
            $user->setCity($city);
            $user->setCountry($city->getCountry());
            if (!empty($newFilename)) {
                $user->setPicture("/pictures/users/admins/profiles/" . $newFilename);
            }
            $user->setRoles(["ROLE_ADMIN"]);
            try {
                $user->setInitialCode(random_int(100000, 999999));
            } catch (Exception $e) {
            }
            $user->setGender($gender);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('admin.index');
        }
    }

    #[Route("/superAdmin/addSuperAdmin{id}",name: "admin.addSuperAdmin",methods: ["GET"])]
    public function makeSuperAdmin($id,UserRepository $userRepository,EntityManagerInterface $entityManager)
    {
        $user = $userRepository->findOneBy(['id'=>$id]);
        $user->setRoles(["ROLE_SUPER_ADMIN"]);
        $user->setPlainPassword(null);
        $user->setActive(false);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute("admin.index");
    }
    #[Route("/superAdmin/removeSuperAdmin/{id}",name: "admin.removeSuperAdmin",methods: ["GET"])]
    public function removeSuperAdmin($id,UserRepository $userRepository,EntityManagerInterface $entityManager)
    {
        $user = $userRepository->findOneBy(['id'=>$id]);
        $user->setRoles(["ROLE_ADMIN"]);
        $entityManager->persist($user);
        $user->setPlainPassword(null);
        $user->setActive(false);
        $entityManager->flush();
        return $this->redirectToRoute("admin.index");
    }
    #[Route("/superAdmin/removeAdmin/{id}",name: "admin.removeAdmin",methods: ["GET"])]
    public function removeAdmin($id,UserRepository $userRepository,EntityManagerInterface $entityManager)
    {
        $user = $userRepository->findOneBy(['id'=>$id]);
        $user->setRoles(["ROLE_REMOVED"]);
        $user->setPlainPassword(null);
        $user->setActive(false);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute("admin.index");
    }
    #[Route("/superAdmin/returnAdmin/{id}",name: "admin.returnAdmin",methods: ["GET"])]
    public function returnAdmin($id,UserRepository $userRepository,EntityManagerInterface $entityManager)
    {
        $user = $userRepository->findOneBy(['id'=>$id]);
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPlainPassword(null);
        $user->setActive(false);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute("admin.index");
    }
    private  CityRepository $cityRepository;
}
