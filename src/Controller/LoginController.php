<?php

namespace App\Controller;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $autheticationUtils): Response
    {
        $error = $autheticationUtils->getLastAuthenticationError();
        $lastUsername = $autheticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username'=>$lastUsername,
            'error'=>$error
        ]);
    }
}
