<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'security.login', methods: ['GET', 'POST'])]
    public function adminLogin(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig', [
            "lastUsername" => $authenticationUtils->getLastUsername(),
            "error" => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    #[Route('/logout', name: 'security.logout')]
    public function logout()
    {
        // nothing to do here
    }


    #[Route('/admin/register', name: 'security.register', methods: ['GET','POST'])]
    public function adminRegister(Request $request, UserRepository $userRepository,EntityManagerInterface $entityManager): Response
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $initialCode = $request->files->get('initialCode');
       $user =  $userRepository->findOneBy(['username'=>$username]);
       if(!$user){
           return $this->render("security/register.html.twig",
           [
               "error"=>"admin not found, you must be registered by a super administrator"
           ]);
       }elseif ($user->isActive()){
           return $this->render("security/register.html.twig",
               [
                   "error"=>"This account is already activated"
               ]);
       }elseif ($user->getInitialCode()!=$initialCode){
           return $this->render("security/register.html.twig",
               [
                   "error"=>"invalid account activation code"
               ]);
       }
            $user->setPlainPassword($password);
            $user->setActive(true);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('security.login');
    }
}

