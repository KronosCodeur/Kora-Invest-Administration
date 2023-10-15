<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\SerializerInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'security.login',methods: ['GET','POST'])]
    public function adminLogin(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig',[
            "lastUsername"=>$authenticationUtils->getLastUsername(),
            "error"=>$authenticationUtils->getLastAuthenticationError()
        ]);
    }
    #[Route('/register', name: 'security.register')]
    public function adminRegister(): Response
    {
        return $this->render('security/register.html.twig');
    }

    #[Route('/logout',name: 'security.logout')]
    public function logout()
    {
        // nothing to do here
    }
    #[Route('/tempRegister', name: 'register',methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $firstName = $request->get('firstName');
        $username = $request->get('username');
        $lastName = $request->get('lastName');
        $password = $request->get('password');
        $phone = $request->get('phone');
        $gender = $request->get('gender');
        $picture = $request->files->get('picture');
        $address = $request->get('address');
        $birthday = $request->get('birthday');
        if($picture){
            $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename . '-' . uniqid() . '.' . $picture->guessExtension();
            $picture->move(
                $this->getParameter('images_directory') . '/users/profiles',
                $newFilename
            );
        }
        $user = new  User();
        $user->setUsername($username);
        $user->setFirstName($firstName);
        $user ->setLastName($lastName);
        $user->setPlainPassword($password);
        $user->setActive(true);
        $user->setBirthday($birthday);
        $user->setAddress($address);
        $user->setPhone($phone);
        $user->setPicture("/pictures/users/profiles/".$newFilename);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setGender($gender);
        $entityManager->persist($user);
        $entityManager->flush();
        $jsonData = $serializer->serialize($user,"json");
        return new  JsonResponse($jsonData,Response::HTTP_OK,[],true);
    }
}

