<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Objectif;
use App\Form\ClientType;
use App\Form\ObjectifType;
use App\Manager\AppManager;
use App\Repository\ClientRepository;
use App\Repository\ObjectifRepository;
use App\Repository\VendeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/admin/edit-user/{id}.html", name="editUser")
     * @param Client $client
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function index(Client $client, Request $request,\Swift_Mailer $mailer): Response{
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $this->em->persist($client);
            $this->em->flush();
            $url = $this->generateUrl('home',[], UrlGeneratorInterface::ABSOLUTE_URL);
            $url_active = $this->generateUrl('active',['email'=> AppManager::encrypt($client->getEmail())], UrlGeneratorInterface::ABSOLUTE_URL);
            $message = (new \Swift_Message('Activation plateforme d’achat d’Energie '))
                ->setFrom('miranga.test@gmail.com')
                ->setTo($client->getEmail())
                ->setBody(
                    $this->renderView(
                        'admin/emailClient.html.twig',[
                            'email'=> $client->getEmail(),
                            'url'=>$url,
                            'nom'=>$client->getNomSignataire(),
                            'prenom'=>$client->getPrenomSignataire(),
                            'urlActive' => $url_active
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            //return $this->redirectToRoute('sendemailclient', ['id'=>$client->getId()]);
        }
        return $this->render('user/editUser.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/active/client.html", name="active")
     */
    public function actifCompte(Request $request, ClientRepository $repository, UserPasswordEncoderInterface $encoder){
        $email = AppManager::decrypt($request->get('email'));
        $client = $repository->findOneBy(['email'=>$email]);
        $client->setState(true);
        $form = $this->createFormBuilder($client)
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe que vous avez entrer n\'est pas identique.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez votre mot de passe'],
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Enrégistrer',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $password = $encoder->encodePassword($client, $client->getPassword());
            $client->setPassword($password);
            $this->em->persist($client);
            $this->em->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/initMdp.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/active/Vendeur.html", name="activeVendeur")
     */
    public function actifCompteVendeur(Request $request, VendeurRepository $repository, UserPasswordEncoderInterface $encoder){
        $email = AppManager::decrypt($request->get('email'));
        $vendeur = $repository->findOneBy(['email'=>$email]);
        $vendeur->setState(true);
        $form = $this->createFormBuilder($vendeur)
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe que vous avez entrer n\'est pas identique.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez votre mot de passe'],
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Enrégistrer',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $password = $encoder->encodePassword($vendeur, $vendeur->getPassword());
            $vendeur->setPassword($password);
            $this->em->persist($vendeur);
            $this->em->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/initMdp.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/admin/edit-budget", name="editBudget")
     * @param Client $client
     * @param Request $request
     * @return Response
     */
    public function budjetEdit(Request $request, ObjectifRepository $repository, ClientRepository $clientRepository): Response{
        $idClient = (int)$request->get('id');
        $perim = $request->get('perim');
        $client = $clientRepository->find($idClient);
        $objectif = $repository->findOneBy(['user'=>$client, 'perimetre'=>$perim]);

        $form = $this->createForm(ObjectifType::class, $objectif);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $this->em->persist($objectif);
            $this->em->flush();
            return $this->redirectToRoute('listeclient');
        }
        return $this->render('user/editObjectif.html.twig',[
            'form' => $form->createView(),
            'client' => $client,
            'objectif' => $objectif
        ]);
    }
}
