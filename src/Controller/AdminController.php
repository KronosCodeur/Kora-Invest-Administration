<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\User;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{


    /**
     * @param UserRepository $userRepository
     * @param CountryRepository $countryRepository
     * @param CityRepository $cityRepository
     */
    public function __construct(UserRepository $userRepository, CountryRepository $countryRepository, CityRepository $cityRepository)
    {
        $this->userRepository = $userRepository;
        $this->countryRepository = $countryRepository;
        $this->cityRepository = $cityRepository;
    }

    #[Route('/admin/admins', name: 'admin.index')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'admins' => $users,
        ]);
    }
    private  UserRepository $userRepository;

    #[Route('/admin/admins/addAdmins', name: 'admin.addAdmin', methods: ["GET",'POST'])]
    public function addAdmin(Request $request,UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        if($request->isMethod("GET")){
            $countries = $this->countryRepository->findAll();
            $cities = $this->cityRepository->findAll();
            return $this->render('admin/add_admin.html.twig',[
                "countries"=>$countries,
                "cities"=>$cities,
                "selected"=>$this->selectedCountry,
                "error"=>""
            ]);
        }else{
            $username = $request->get('username');
            if($userRepository->findOneBy(['username'=>$username])){
                $countries = $this->countryRepository->findAll();
                $cities = $this->cityRepository->findAll();
                return $this->render('admin/add_admin.html.twig',[
                    "countries"=>$countries,
                    "cities"=>$cities,
                    "selected"=>$this->selectedCountry,
                    "error"=>"This username is already registered"
                ]);
            }
            $firstName = $request->get('firstName');
            $lastName = $request->get('lastName');
            $registeredAt = $request->get('dateRegistration');
            $phone = $request->get('phone');
            $gender = $request->get('gender');
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
    private  CityRepository $cityRepository;

}
