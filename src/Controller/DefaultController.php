<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        if($this->getUser() == null){
            return $this->redirectToRoute('app_login');
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
