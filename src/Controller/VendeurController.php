<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VendeurController extends AbstractController
{
    /**
     * @Route("/vendeur", name="vendeur")
     */
    public function index(): Response
    {
        $client = $this->getUser()->getClients();
        return $this->render('vendeur/index.html.twig',[
            'client'=>$client
        ]);
    }
}
