<?php

namespace App\Controller;

use App\Entity\User;
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

    #[Route('/admin/clients/addClient', name: 'client.addClient', methods: ["GET",'POST'])]
    public function addClient(Request $request, EntityManagerInterface $entityManager): Response
    {
        if($request->isMethod("GET")){
            return $this->render('client/add_client.html.twig');
        }else{
            $firstName = $request->get('firstName');
            $username = $request->get('username');
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
            return $this->redirectToRoute('clients.index');
        }
    }
}
