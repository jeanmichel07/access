<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthentificationController extends AbstractController
{

    public function login(AuthenticationUtils $utils){
        if($this->getUser() == null){
            $lasteUsername=$utils->getLastUsername();
            $error=$utils->getLastAuthenticationError();
            return $this->render('authentification/login.html.twig',[
                'lastUsername'=>$lasteUsername,
                'error'=>$error
            ]);
        }else{
            $role = $this->getUser()->getRoles();
            if($role[0] == "ROLE_ADMIN"){
                return $this->redirectToRoute('admin');
            }elseif($role[0] == "ROLE_CLIENT"){
                return $this->redirectToRoute('client');
            }elseif($role[0] == "ROLE_VENDEUR"){
                return $this->redirectToRoute('vendeur');
            }
        }

    }
}
