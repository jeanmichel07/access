<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\BudgetGaz;
use App\Entity\Client;
use App\Entity\DetailleOffreGaz;
use App\Entity\DetailOffreElec;
use App\Entity\InfoSuplementaireElec;
use App\Entity\InfoSuplementaireGaz;
use App\Entity\Objectif;
use App\Entity\OffreElectricite;
use App\Entity\OffreGaz;
use App\Entity\PerimetreElectricite;
use App\Entity\PermetreGaz;
use App\Entity\PrixForPerimetreElec;
use App\Entity\Segmentation;
use App\Entity\Vendeur;
use App\Form\AdminType;
use App\Form\PerimetreElectriciteType;
use App\Manager\AppManager;
use App\Repository\ClientRepository;
use App\Repository\InfoSuplementaireElecRepository;
use App\Repository\InfoSuplementaireGazRepository;
use App\Repository\ListOffreParFounisseurRepository;
use App\Repository\ObjectifRepository;
use App\Repository\OffreElectriciteRepository;
use App\Repository\OffreGazRepository;
use App\Repository\PerimetreElectriciteRepository;
use App\Repository\PermetreGazRepository;
use App\Repository\PrixForPerimetreElecRepository;
use App\Repository\SegmentationRepository;
use App\Repository\VendeurRepository;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="admin")
     * @param ClientRepository $clientRepository
     * @param OffreElectriciteRepository $electriciteRepository
     * @return Response
     */
    public function index(ClientRepository $clientRepository, OffreElectriciteRepository $electriciteRepository, OffreGazRepository $gazRepository){
        $nbr_client = sizeof($clientRepository->findClient());
        $nbr_client_gaz = sizeof($clientRepository->findClientNotGaz());
        $nbr_offre_elec_en_attente = sizeof($electriciteRepository->findBy(['status'=>'En attent']));
        $nbr_offre_gaz_en_attente = sizeof($gazRepository->findBy(['status'=>'En attent']));
        return $this->render('admin/index.html.twig', [
            'nbr_client' => $nbr_client,
            'nbr_client_gaz' => $nbr_client_gaz,
            'nbroffreelecenattente' => $nbr_offre_elec_en_attente,
            'nbroffregazenattente' => $nbr_offre_gaz_en_attente
        ]);
    }

    /**
     * @Route("/edit.password.{id}", name="editPassword")
     */
    public function EditPassword(Admin $admin, UserPasswordEncoderInterface $encoder, Request $request){
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $password = $encoder->encodePassword($admin, $admin->getPassword());
            $admin->setPassword($password);
            $this->em->persist($admin);
            $this->em->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/password.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/clien.list.html", name="listeclient")
     * @param ClientRepository $repository
     * @return Response
     */
    public function listClient(ClientRepository $repository){
        $client = $repository->findAllClient();
        return $this->render('admin/listClient.html.twig',[
            'client'=>$client
        ]);
    }

    /**
     * @param ClientRepository $repository
     * @param Request $request
     * @return JsonResponse
     * @Route("/filter")
     */
    public function filetrClient(ClientRepository $repository, Request $request){
        $seg = $request->get('seg');
        $vendeur = $request->get('vendeur');
        $state = $request->get('state');
        $clients = $request->get('client');
        $client = $repository->getClientByFilter($seg, $vendeur, $state, $clients);
        $forma = [];
        foreach ($client as $el){
            $consomElec = null;
            foreach ($el->getPerimetreElectricites() as $perimetreElectricite){
                $consomElec += $perimetreElectricite->getTotal();
            }

            $consomGaz = null;
            foreach ($el->getPermetreGazs() as $perimGaz){
                $consomGaz += $perimGaz->getCAR();
            }

            $seg = [];
            foreach ($el->getPerimetreElectricites() as $perimetreElectricite){
                $seg [] = $perimetreElectricite->getSegmentation()->getNom().',';
            }
            $forma [] = [
              'id' => $el->getId(),
              'raison' => $el->getRaisonSocial(),
              'nom' => $el->getNomSignataire().' '.$el->getPrenomSignataire(),
              'contact' => $el->getTelephone(),
              'consommation_elec' => $consomElec,
              'consommation_gaz' => $consomGaz,
              'state' => $el->getStatut(),
              'vendeur' => $el->getVendeur() != null? $el->getVendeur()->getNom() : "",
              'segmentation' => implode(',',$seg),
            ];
        }
        return $this->json($forma);
    }
    /**
     * @param Request $request
     * @param VendeurRepository $vendeurRepository
     * @return Response
     * @Route("/client.new.html", name="newClient")
     */
    public function newClient(Request $request, VendeurRepository $vendeurRepository){
        $client = new Client();
        $form = $this->createFormBuilder($client)
            ->add('raisonSocial', TextType::class,['required'=>true])
            ->add('nomSignataire', TextType::class,['required'=>true])
            ->add('fonctionSignataire', TextType::class,['required'=>true])
            ->add('prenomSignataire', TextType::class,[
                'required'=>true,
                'label'=>'Prénom signataire'
            ])
            ->add('fonctionSignataire', TextType::class,['required'=>true])
            ->add('telephone', TextType::class,[
                'required'=>true,
                'label'=>'Téléphone'
            ])
            ->add('email', TextType::class,['required'=>true])
            ->add('vendeur', EntityType::class,[
                'class'=>Vendeur::class,
                'query_builder'=>function(EntityRepository $s){
                    return $s->createQueryBuilder('v')->orderBy('v.nom');
                }
            ])
            ->add('nbrSiteElec', NumberType::class,['label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'00'
                ]
                ])
            ->add('nbrSiteGaz', NumberType::class,['label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'00'
                ]
                ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $infos = $request->get('form');
            $vId = isset($infos['vendeur'])? (int)$infos['vendeur']: null;
            if($vId != null){
                $vend = $vendeurRepository->find($vId);
            }else{
                $vend = null;
            };
            $client
                ->setVendeur($vend)
                ->setStatut('En cour')->setState(false)->setType(1);
            $this->em->persist($client);
            $this->em->flush();
            if(isset($_POST['elec']))
            {
                return $this->redirectToRoute('addPerimetreElec',['id'=>$client->getId()]);
            }else{
                return $this->redirectToRoute('addGazElec',['id'=>$client->getId()]);
            }

        }
        return $this->render('admin/newClient.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Client $client
     * @param VendeurRepository $vendeurRepository
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/client.edit-{id}.html", name="editClient")
     */
    public function editClient(Client $client, VendeurRepository $vendeurRepository, Request $request){
        $form = $this->createFormBuilder($client)
            ->add('raisonSocial', TextType::class,['required'=>true])
            ->add('nomSignataire', TextType::class,['required'=>true])
            ->add('prenomSignataire', TextType::class,[
                'required'=>true,
                'label'=>'Prénom'
            ])
            ->add('fonctionSignataire', TextType::class,['required'=>true])
            ->add('telephone', TextType::class,[
                'required'=>true,
                'label'=>'Téléphone'
            ])
            ->add('email', TextType::class,['required'=>true])
            ->add('vendeur', EntityType::class,[
                'class'=>Vendeur::class,
                'query_builder'=>function(EntityRepository $s){
                    return $s->createQueryBuilder('v')->orderBy('v.nom');
                }
            ])
            ->add('nbrSiteElec', NumberType::class,['label'=>false,
                'attr'=>[
                    'placeholder'=>'00'
                ]
            ])
            ->add('nbrSiteGaz', NumberType::class,['label'=>false,
                'attr'=>[
                    'placeholder'=>'00'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $infos = $request->get('form');
            $vId = isset($infos['vendeur'])? (int)$infos['vendeur']: null;
            if($vId != null){
                $vend = $vendeurRepository->find($vId);
            }else{
                $vend = null;
            }
            $client
                ->setVendeur($vend);
            $this->em->persist($client);
            $this->em->flush();

            if(isset($_POST['elec']))
            {
                return $this->redirectToRoute('addPerimetreElec',['id'=>$client->getId()]);
            }else{
                return $this->redirectToRoute('addGazElec',['id'=>$client->getId()]);
            }
        }
        return $this->render('admin/editClient.html.twig',[
            'form' => $form->createView(),
            'client'=>$client
        ]);
    }
    /**
     * @param Client $client
     * @param VendeurRepository $vendeurRepository
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/client.edit2-{id}.html", name="editDeuxClient")
     */
    public function edit2Client(Client $client, VendeurRepository $vendeurRepository, Request $request){
        $form = $this->createFormBuilder($client)
            ->add('raisonSocial', TextType::class,['required'=>true])
            ->add('nomSignataire', TextType::class,['required'=>true])
            ->add('prenomSignataire', TextType::class,['required'=>true])
            ->add('fonctionSignataire', TextType::class,['required'=>true])
            ->add('telephone', TextType::class,['required'=>true])
            ->add('email', TextType::class,['required'=>true])
            ->add('vendeur', EntityType::class,[
                'class'=>Vendeur::class,
                'query_builder'=>function(EntityRepository $s){
                    return $s->createQueryBuilder('v')->orderBy('v.nom');
                }
            ])
            ->add('nbrSiteElec', NumberType::class,['label'=>false,
                'attr'=>[
                    'placeholder'=>'00'
                ]
            ])
            ->add('nbrSiteGaz', NumberType::class,['label'=>false,
                'attr'=>[
                    'placeholder'=>'00'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $infos = $request->get('form');
            $vId = isset($infos['vendeur'])? (int)$infos['vendeur']: null;
            if($vId != null){
                $vend = $vendeurRepository->find($vId);
            }else{
                $vend = null;
            }
            $client
                ->setVendeur($vend);
            $this->em->persist($client);
            $this->em->flush();
            if(isset($_POST['elec']))
            {
                return $this->redirectToRoute('addPerimetreElec',['id'=>$client->getId()]);
            }else{
                return $this->redirectToRoute('addGazElec',['id'=>$client->getId()]);
            }
        }
        return $this->render('admin/editDeuxClient.html.twig',[
            'form' => $form->createView(),
            'client'=>$client
        ]);
    }
    /**
     * @param Client $client
     * @param Request $request
     * @return Response
     * @throws \Exception
     * @Route("/add/perimetre.electricite-{id}.html", name="addPerimetreElec")
     */
    public function addPerimetreElec(Client $client, Request $request){
        $perElec = new PerimetreElectricite();

        $form = $this->createForm(PerimetreElectriciteType::class, $perElec);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
                $total = (double)$perElec->getPte() + (double)$perElec->getHCE() + (double)$perElec->getHCH() + (double)$perElec->getHPE() + (double)$perElec->getHPH();
                $perElec
                    ->setClient($client)
                    ->setStatut('En Cour')
                    ->setTotal($total);
                $this->em->persist($perElec);
                $this->em->flush();
                $prixForPerimElec = new PrixForPerimetreElec();
                $compComptage = $perElec->getSegmentation()->getCompComptages()[0]->getValue();
                $compGestion = $perElec->getSegmentation()->getCompGestions()[0]->getValue();
                $d3 = $perElec->getPsHPH();
                $n7 = $perElec->getSegmentation()->getCompSoustiragePartFixes()[0]->getHph();
                $i3 = $perElec->getHCH();
                $h3 = $perElec->getHPH();
                $o7 = $perElec->getSegmentation()->getCompSoustiragePartFixes()[0]->getHch();
                $j3 = $perElec->getHPE();
                $p7 = $perElec->getSegmentation()->getCompSoustiragePartFixes()[0]->getHpe();
                $k3 = $perElec->getHCE();
                $q7 = $perElec->getSegmentation()->getCompSoustiragePartFixes()[0]->getHce();
                $n10 = $perElec->getSegmentation()->getCompSoustiragePartVariables()[0]->getHph();
                $o10 = $perElec->getSegmentation()->getCompSoustiragePartVariables()[0]->getHch();
                $p10 = $perElec->getSegmentation()->getCompSoustiragePartVariables()[0]->getHpe();
                $q10 = $perElec->getSegmentation()->getCompSoustiragePartVariables()[0]->getHce();
                $partFixe = AppManager::calculPartFixe($d3, $n7, $i3, $h3, $o7, $j3, $p7, $k3, $q7);
                $partVariable = AppManager::calculPartVariable($h3, $n10, $i3, $o10, $j3, $p10, $k3, $q10);

                $cspe = $perElec->getTotal() * 22.5;
                $cta = ($compComptage + $compGestion + $partFixe)* 27.04/100;
                $tcfe = $perElec->getTotal() * 3.3149 ;

                $budgetHTT = ($perElec->getPsPte()*$perElec->getPte())+($perElec->getPsHPH()*$perElec->getHPH())+($perElec->getPsHCH()*$perElec->getHCH())+($perElec->getPsHCE()*$perElec->getHCE())+($perElec->getPsHPE()*$perElec->getHPE());
                $totalHT = $compComptage + $compGestion + $partFixe + $partVariable + $budgetHTT;
                $totalHTVA = $totalHT + $cspe + $cta + $tcfe;

                $prixForPerimElec->setPerimetreElectricite($perElec)
                    ->setCompComptage($compComptage)
                    ->setCompGestion($compGestion)
                    ->setCspe($cspe)
                    ->setTcfe($tcfe)
                    ->setCta($cta)
                    ->setPartFixe($partFixe)
                    ->setPartVariable($partVariable)
                    ->setTotalHT($totalHT)
                    ->setTotalHTVA($totalHTVA)
                    ->setBudgetHTT($budgetHTT);
            $this->em->persist($prixForPerimElec);
            $this->em->flush();
                return $this->redirectToRoute('addPerimetreElec',['id'=>$client->getId()]);

        }
        if(isset($_POST['btnOb'])){
            $objectif = new Objectif();
            $objectif->setUser($client)
                ->setPerimetre('elec')
                ->setStrategieCommercial($_POST['strat'])
                ->setValeur((float)$_POST['objectif']);
            $this->em->persist($objectif);
            $this->em->flush();
            return $this->redirectToRoute('editClient',['id'=>$client->getId()]);
        }
        return $this->render('admin/newPerElec.html.twig',[
            'form'=>$form->createView(),
            'client'=>$client
        ]);
    }

    /**
     * @param OffreElectriciteRepository $repository
     * @param Client $client
     * @param OffreGazRepository $gazRepository
     * @return Response
     * @Route("/historique-{id}.html", name = "historique")
     */
    public function historique(OffreElectriciteRepository $repository, Client $client, OffreGazRepository $gazRepository){
        $elec = $repository->findAlls($client);
        $gaz = $gazRepository->findAlls($client);

        for($i = 0; $i < sizeof($client->getPerimetreElectricites()); $i++){
            if($elec)
            $compComptages = $client->getPerimetreElectricites()[$i]->getSegmentation()->getCompComptages()[0]->getValue();
            $compGestions = $client->getPerimetreElectricites()[$i]->getSegmentation()->getCompGestions()[0]->getValue();
        }

        return $this->render('admin/historique.html.twig',[
            'elec'=>$elec,
            'gaz'=>$gaz,
            'client'=>$client
        ]);

    }

    /**
     * @param OffreElectricite $offreElectricite
     * @return Response
     * @Route("/historique/detail-{id}.html", name = "detailhistorique")
     */
    public function detailHistoriqueElec(OffreElectricite $offreElectricite, InfoSuplementaireElecRepository $repository, ObjectifRepository $objectifRepository){
        $objectif = $objectifRepository->findObjectElec($offreElectricite->getClient(), 'elec');
        $objectifElec = $objectif->getValeur();
        $infoSupliElec = $repository->findByOffreElec($offreElectricite);
       return $this->render('admin/detailhistorique.html.twig',[
            'elec'=>$offreElectricite,
            'info'=> $infoSupliElec[0] != null ? $infoSupliElec[0]: [],
            'objectif'=>$objectifElec
        ]);
    }

    /**
     * @param OffreGaz $offreGaz
     * @param InfoSuplementaireGazRepository $repository
     * @param ObjectifRepository $objectifRepository
     * @return Response
     * @Route("/historique/detailgaz-{id}.html", name = "detailhistoriquegaz")
     */
    public function detailHistoriqueGaz(OffreGaz $offreGaz, InfoSuplementaireGazRepository $repository, ObjectifRepository $objectifRepository){
        $objectif = $objectifRepository->findObjectElec($offreGaz->getClient(), 'gaz');
        $objectifGaz = $objectif->getValeur();
        $infoSupliElec = $repository->findByOffreGaz($offreGaz);
        return $this->render('admin/detailhistoriqueGaz.html.twig',[
            'gaz'=>$offreGaz,
            'info'=> $infoSupliElec[0] != null ? $infoSupliElec[0] : [],
            'objectif'=>$objectifGaz
        ]);
    }
    /**
     * @param Client $client
     * @param Request $request
     * @return Response
     * @throws \Exception
     * @Route("/add/perimetre.gaz-{id}.html", name="addGazElec")
     */
    public function addPerimetreGaz(Client $client, Request $request){
        $perGaz = new PermetreGaz();
        $form = $this->createFormBuilder($perGaz)
            ->add('dateFourniture', DateType::class, ['widget' => 'single_text','label'=>'Date de début de fourniture '])
            ->add('PCE', TextType::class,['label'=>'PCE'])
            ->add('nomPtLivraison', TextType::class, ['label'=>'Nom du point de livraison '])
            ->add('CAR', TextType::class, ['label'=>'CAR'])
            ->add('profil', ChoiceType::class, [
                'choices'=>['T1'=>'T1','T2'=>'T2','T3'=>'T3'],
                'label'=>'Profil'])
            ->add('tarifDistribution', ChoiceType::class, [
                'choices'=>['PO11'=>'PO11','PO12'=>'PO12','PO13'=>'PO13','PO14'=>'PO14','PO15'=>'PO15','PO16'=>'PO16','PO17'=>'PO17','PO18'=>'PO18','PO19'=>'PO19',],
                'label'=>'Tarif de distribution '])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $infos = $request->get('form');
            $perGaz->setClient($client)
                ->setDateFourniture(new \DateTime($infos['dateFourniture']))
                ->setCAR($infos['CAR'])
                ->setPCE($infos['PCE'])
                ->setTarifDistribution($infos['tarifDistribution'])
                ->setNomPtLivraison($infos['nomPtLivraison'])
                ->setProfil($infos['profil'])
                ->setStatut('En Cour');
            $this->em->persist($perGaz);
            $this->em->flush();
            return $this->redirectToRoute('addGazElec', ['id'=>$client->getId()]);
        }
        if(isset($_POST['btnOb'])){
            $objectif = new Objectif();
            $objectif->setUser($client)
                ->setPerimetre('gaz')
                ->setStrategieCommercial($_POST['strat'])
                ->setValeur((float)$_POST['objectif']);
            $this->em->persist($objectif);
            $this->em->flush();
            return $this->redirectToRoute('editDeuxClient',['id'=>$client->getId()]);
        }
        return $this->render('admin/newPerGaz.html.twig', [
            'form'=>$form->createView(),
            'client'=>$client
        ]);
    }
    /**
     * @Route("/detailles/client-{id}.html", name="detailleClient")
     * @param Client $client
     * @return Response
     */
    public function detailClient(Client $client){
        return $this->render('admin/detailleClient.html.twig',['c'=>$client]);
    }
    /**
     * @param \Swift_Mailer $mailer
     * @param Request $request
     * @param Client $client
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse
     * @Route("/send/email.client-{id}.html", name="sendemailclient")
     */
    public function sendEmail(\Swift_Mailer $mailer, Request $request, Client $client, UserPasswordEncoderInterface $encoder){
        $plainPassword = date("Y").'clt'.$client->getId().$client->getPrenomSignataire();
        $encoded = $encoder->encodePassword($client, $plainPassword);
        $client->setUsername('clt'.$client->getId().''.date("Y"))->setPassword($encoded);
        $this->em->persist($client);
        $this->em->flush();
        $url = $this->generateUrl('home',[], UrlGeneratorInterface::ABSOLUTE_URL);
        $url_active = $this->generateUrl('active',['email'=> AppManager::encrypt($client->getEmail())], UrlGeneratorInterface::ABSOLUTE_URL);
        $message = (new \Swift_Message('Activation plateforme d’achat d’Energie '))
            ->setFrom('h.diakite@accessenergies.fr')
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
        return $this->redirectToRoute('listeclient');
    }
    /**
     * @Route("/vendeur.list.html", name="listVendeur")
     * @param VendeurRepository $repository
     * @return Response
     */
    public function indexVendeur(VendeurRepository $repository){
        $vendeur = $repository->findAll();
        return $this->render('admin/listVendeur.html.twig',['v'=>$vendeur]);
    }
    /**
     * @param Request $request
     * @return Response
     * @Route("/vendeur.new.html", name="newVendeur")
     */
    public function newVendeur(Request $request){
        $vendeur = new Vendeur();
        $form = $this->createFormBuilder($vendeur)
            ->add('nom', TextType::class, [
                'label'=>'Nom du commercial'
            ])
            ->add('prenom', TextType::class,[
                'label'=>'Prénom du commercial'
            ])
            ->add('fonction', TextType::class,[
                'label'=>'Organisme'
            ])
            ->add('email')
            ->add('contact')->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $infos = $request->get('form');
            $vendeur->setState(false)->setType(2);
            $this->em->persist($vendeur);
            $this->em->flush();
            return $this->redirectToRoute('sendemailVendeur',['id'=>$vendeur->getId()]);
        }
        return $this->render('admin/newVendeur.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @param \Swift_Mailer $mailer
     * @param Request $request
     * @param Vendeur $vendeur
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse
     * @Route("/send/email.vendeur-{id}.html", name="sendemailVendeur")
     */
    public function sendEmailVendeur(\Swift_Mailer $mailer, Request $request, Vendeur $vendeur, UserPasswordEncoderInterface $encoder){
        $plainPassword = date("Y").'vdr'.$vendeur->getId().$vendeur->getPrenom();
        $encoded = $encoder->encodePassword($vendeur, $plainPassword);
        $vendeur->setUsername('vdr'.$vendeur->getId().''.date("Y"))->setPassword($encoded);
        $this->em->persist($vendeur);
        $this->em->flush();
        $url = $this->generateUrl('home', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $url_active = $this->generateUrl('activeVendeur',['email'=> AppManager::encrypt($vendeur->getEmail())], UrlGeneratorInterface::ABSOLUTE_URL);

        $message = (new \Swift_Message('Activation plateforme d’achat d’Energie '))
            ->setFrom('h.diakite@accessenergies.fr')
            ->setTo($vendeur->getEmail())
            ->setBody(
                $this->renderView(
                    'admin/emailClient.html.twig',[
                        'email'=>$vendeur->getEmail(),
                        'password'=>$plainPassword,
                        'nom' => $vendeur->getNom(),
                        'prenom' => $vendeur->getPrenom(),
                        'url' => $url,
                        'urlActive' => $url_active
                    ]
                ),
                'text/html'
            );
        $mailer->send($message);
        return $this->redirectToRoute('listVendeur');
    }

    /**
     * @Route("/listOffreElec.html", name="listOffreElec" )
     */
    public function listOffreElec(OffreElectriciteRepository $repository)
    {
        $listOffreElec = $repository->findAll();
        return $this->render('admin/listOffreElec.html.twig',[
            'listOffreElec'=>$listOffreElec
        ]);
    }

    /**
     * @Route("/newOffreElec-{id}.html", name="newOffreElec")
     * @param Request $request
     * @param Client $client
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function newOffreElec(Request $request, Client $client){
        $offreElec = new OffreElectricite();
        $form = $this->createFormBuilder($offreElec)->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $fornisseur[] = [];
            // dd($_POST);
            for($i=1; $i<sizeof($_POST) - 2;$i++){
                $fornisseur[$i-1] = $_POST['fourni'.$i];
            }
            $infos = $request->get('form');
            $offreElec->setFournisseur($fornisseur)
                ->setNbrOffre($_POST['nbrOffre'])
                ->setClient($client)
                ->setCreatedAt(new \DateTime())
                ->setStatus('En attent')
                ->setNbrAccepted(0)
                ->setNbrDeclined(0)
                ->setVue(0)
                ->setSegmentation($_POST['segmentation']);
            $this->em->persist($offreElec);
            $this->em->flush();
            return $this->redirectToRoute('detailOffreElec',['id'=>$offreElec->getId()]);
        }
        return $this->render('admin/newOffreElec.html.twig',['form'=>$form->createView(), 'user'=>$client]);
    }

    /**
     * @param ClientRepository $repository
     * @param OffreElectriciteRepository $offreElectriciteRepository
     * @return JsonResponse
     * @Route("/verif", name="verif")
     */
    public function verificationSegmentation(ClientRepository $repository, OffreElectriciteRepository $offreElectriciteRepository){
        $sagmentation = $_GET['seg'];
        $clientId = (int)$_GET['client'];
        $client = $repository->find($clientId);
        $offExiste = $offreElectriciteRepository->findBySegmentation($sagmentation, $client);
        $taille = sizeof($offExiste);
        return new JsonResponse(['taille'=>$taille]);
    }

    /**
     * @param ClientRepository $repository
     * @param OffreGazRepository $offreGazRepository
     * @return JsonResponse
     * @Route("/verif/profil", name="verifProfil")
     */
    public function verificationProfil(ClientRepository $repository, OffreGazRepository $offreGazRepository){
        $profil = $_GET['profil'];
        $clientId = (int)$_GET['client'];
        $client = $repository->find($clientId);
        $offExiste = $offreGazRepository->findByProfil($profil, $client);
        $taille = sizeof($offExiste);
        return new JsonResponse(['taille'=>$taille]);
    }
    /**
     * @param Request $request
     * @param OffreElectricite $offreElectricite
     * @Route("/detailOffreElec-{id}.html", name="detailOffreElec")
     * @return Response
     */
    public function detailOffreElec(Request $request, OffreElectricite $offreElectricite, PerimetreElectriciteRepository $repository, SegmentationRepository $segmentationRepository, PrixForPerimetreElecRepository $perimetreElecRepository, ObjectifRepository $objectifRepository){
        $detailOffreElec = new DetailOffreElec();
        $form = $this->createFormBuilder($detailOffreElec)
            ->add('prAbonnementParAn', NumberType::class,['label'=>'Prix d\'abonnement par an'])
            ->add('prPte', NumberType::class,['label'=>'Prix Pte'])
            ->add('dure_en_mois', TextType::class,['label'=>'Durée en mois'])
            ->add('prHPH', NumberType::class,['label'=>'Prix HPH'])
            ->add('prHCH', NumberType::class,['label'=>'Prix HPC'])
            ->add('prHPE', NumberType::class,['label'=>'Prix HPE'])
            ->add('prHCE', NumberType::class,['label'=>'Prix HCE'])->getForm();

        $sementation = $segmentationRepository->findOneBy(['nom'=>$offreElectricite->getSegmentation()]);
        $perimetre = $repository->findOneBy(['client'=>$offreElectricite->getClient(), 'segmentation'=>$sementation]);
        $consHPH = $perimetre->getHPH();
        $consHCH = $perimetre->getHCH();
        $consHPE = $perimetre->getHPE();
        $consHCE = $perimetre->getHCE();
        $consPte = $perimetre->getPte();

        $prixForPerminElec = $perimetreElecRepository->findOneBy(['PerimetreElectricite'=>$perimetre]);
        $compComposant = $prixForPerminElec->getCompComptage();
        $compGestion = $prixForPerminElec->getCompGestion();
        $partFixe = $prixForPerminElec->getPartFixe();
        $partVariable = $prixForPerminElec->getPartVariable();
        $cspe = $prixForPerminElec->getCspe();
        $cta = $prixForPerminElec->getCta();
        $tcfe = $prixForPerminElec->getTcfe();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $prHPH = $detailOffreElec->getPrHPH();
            $prHCH = $detailOffreElec->getPrHCH();
            $prHPE = $detailOffreElec->getPrHPE();
            $prHCE = $detailOffreElec->getPrHCE();
            $prPte = $detailOffreElec->getPrPte();
            $AbonnementParAn = $detailOffreElec->getPrAbonnementParAn();
            $budgetHTT = ($consPte*$prPte)+($consHPH*$prHPH)+($consHCH*$prHCH)+($consHPE*$prHPE)+($consHCE*$prHCE)+$AbonnementParAn;
            $detailOffreElec->setBudgetHTT($budgetHTT)->setOffre($offreElectricite)->setFournisseur($request->get('fournisseur'))->setStatut('created');
            $totalHT = $compComposant+$compGestion+$partFixe+$partVariable+$budgetHTT;
            $detailOffreElec->setTotalHT($totalHT);
            $totalHTVA = $cspe+$cta+$tcfe+$totalHT;
            $detailOffreElec->setTotalHTVA($totalHTVA);
            $budgetCible = $objectifRepository->findBy(['user'=>$detailOffreElec->getOffre()->getClient(), 'perimetre'=>'elec']);
            $cible = $budgetCible[sizeof($budgetCible) - 1];
            $voir = $request->get('voir');
            if(isset($voir)){

            }else{
                $this->em->persist($detailOffreElec);
                $this->em->flush();
                return $this->redirectToRoute('detailOffreElec', ['id' => $offreElectricite->getId()]);
            }
            $ecart = (float)$totalHTVA>(float)$cible->getValeur() ? (float)$totalHTVA-(float)$cible->getValeur(): (float)$cible->getValeur() - (float)$totalHTVA;
            return $this->render('admin/detailOffreElec.html.twig',[
                'form'=>$form->createView(),
                'offre'=>$offreElectricite,
                'cible' => $cible,
                'budget' => $totalHTVA,
                'ecart' => $ecart,
                'id' => $offreElectricite->getId()
            ]);
            // return $this->redirectToRoute('detailOffreElec',['id'=>$offreElectricite->getId()]);
        }
        return $this->render('admin/detailOffreElec.html.twig',[
            'form'=>$form->createView(),
            'offre'=>$offreElectricite,
            'id' => $offreElectricite->getId()
        ]);
    }

    /**
     * @param OffreElectricite $offreElectricite
     * @Route("/new/infos-supli-{id}.html", name="newInfoSupliElec")
     * @return Response
     */
    public function addInfoSupliElec(OffreElectricite $offreElectricite, Request $request){
        $infoSupli = new InfoSuplementaireElec();
        $form = $this->createFormBuilder($infoSupli)
            ->add('cal24',TextType::class,[
                'label'=>'CAL-24'
            ])
            ->add('cal22',TextType::class,[
                'label'=>'CAL-22'
            ])
            ->add('cal23',TextType::class,[
                'label'=>'CAL-23'
            ])->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $infos = $request->get('form');
            $infoSupli->setCal24($infos['cal24'])
                ->setCal22($infos['cal22'])
                ->setCal23($infos['cal23'])
                ->setOffreElec($offreElectricite);
            $this->em->persist($infoSupli);
            $this->em->flush();
            return $this->redirectToRoute('historique',['id'=>$offreElectricite->getClient()->getId()]);
        }
        return $this->render('admin/newInfoSupliElec.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param OffreGaz $offreGaz
     * @param Request $request
     * @return Response
     * @Route("/new/infos-supli/gaz-{id}.html", name="newInfoSupliGaz")
     */
    public function addInfoSupliGaz(OffreGaz $offreGaz, Request $request){
        $infoSupliGaz = new InfoSuplementaireGaz();
        $form = $this->createFormBuilder($infoSupliGaz)
            ->add('cal24',TextType::class,[
                'label'=>'CAL-24'
            ])
            ->add('cal22',TextType::class,[
                'label'=>'CAL-22'
            ])
            ->add('cal23',TextType::class,[
                'label'=>'CAL-23'
            ])->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $infos = $request->get('form');
            $infoSupliGaz->setCal24($infos['cal24'])
                ->setCal22($infos['cal22'])
                ->setCal23($infos['cal23'])
                ->setOffreGaz($offreGaz);
            $this->em->persist($infoSupliGaz);
            $this->em->flush();
            return $this->redirectToRoute('historique',['id'=>$offreGaz->getClient()->getId()]);
        }
        return $this->render('admin/newInfoSupliGaz.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param Client $client
     * @return Response
     * @Route("/perimetre/client-{id}.htm", name = "perimetreClient")
     */
    public function listPerimetreParClient(Client $client){
        return $this->render('admin/perimetreClient.html.twig',[
            'client'=>$client
        ]);
    }
    /**
     * @Route("/showdetailleOffreElec-{id}.html", name="showdetailleOffreElec")
     * @param OffreElectricite $offreElectricite
     * @return Response
     */
    public function showdetailleOffreElec(OffreElectricite $offreElectricite)
    {
        return $this->render('admin/showdetailleOffreElec.html.twig',['offre'=>$offreElectricite]);
    }
    /**
     * @Route("/listOffreGaz.html", name="listOffreGaz")
     * @param OffreGazRepository $gazRepository
     * @return Response
     */
    public function listOffreGaz(OffreGazRepository $gazRepository)
    {
        $gazOffre = $gazRepository->findAll();
        return $this->render('admin/listOffreGaz.html.twig',[
            'offregaz'=>$gazOffre
        ]);
    }

    /**
     * @param Request $request
     * @param Client $client
     * @return Response
     * @throws \Exception
     * @Route("/newOffreGaz-{id}.html", name="newOffreGaz")
     */
    public function newOffreGaz(Request $request, Client $client){
        $offreGaz = new OffreGaz();
        $form = $this->createFormBuilder($offreGaz)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $fornisseur=[];
            $dureEnMois= [];
            for($i = 1;$i<=sizeof($_POST); $i ++){
                if(isset($_POST['fourni'.$i]) and $_POST['fourni'.$i] != ""){
                    $fornisseur [] = $_POST['fourni'.$i];
                }
                if(isset($_POST['fourni'.$i]) and $_POST['dure-en-mois'.$i] != ""){
                    $dureEnMois [] = $_POST['dure-en-mois'.$i];
                }
            }
            $offreGaz->setFournisseur($fornisseur)->setDureeEnMois($dureEnMois)
                ->setNbrOffre($_POST['nbrOffre'])
                ->setCreatedAt(new \DateTime())
                ->setProfil($_POST['profil'])
                ->setClient($client)
                ->setNbrAccepted(0)
                ->setNbrDeclined(0)
                ->setVue(0)
            ->setStatus('En attent');

            $this->em->persist($offreGaz);
            $this->em->flush();
            return $this->redirectToRoute('detailleOffreGaz',['id'=>$offreGaz->getId()]);
        }
        return $this->render('admin/newOffreGaz.html.twig',['form'=>$form->createView(), 'user'=>$client]);
    }
    /**
     * @param Request $request
     * @param OffreGaz $offreGaz
     * @Route("/detailleOffreGaz-{id}.html", name="detailleOffreGaz")
     * @return Response
     */
    public function detailleOffreGaz(Request $request, OffreGaz $offreGaz, PermetreGazRepository $gazRepository, ObjectifRepository $objectifRepository)
    {
        $perimetr = $gazRepository->findByClient($offreGaz->getClient());
        $index = sizeof($offreGaz->getDetailleOffreGazs());
        $CAR = $perimetr->getCar();
        if($offreGaz->getNbrOffre() == $index){
            $dureEnMois =(int)$offreGaz->getDureeEnMois()[$index-1];
        }else{
            $dureEnMois =(int)$offreGaz->getDureeEnMois()[$index];
        }
        $detailleoffreGaz = new DetailleOffreGaz();
        $form = $this->createFormBuilder($detailleoffreGaz)
            ->add('prAbonnParMois', TextType::class,['label'=>'Prix Abonnement par mois'])
            ->add('prGaz', TextType::class,['label'=>'Prix gaz'])
            ->add('tqa', TextType::class,['label'=>'TQA'])
            ->add('cee', TextType::class,['label'=>'CEE'])
            ->add('cta', TextType::class,['label'=>'CTA'])->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $infos = $request->get('form');
            $detailleoffreGaz
                ->setOffre($offreGaz)
                ->setTqa($infos['tqa'])
                ->setCee($infos['cee'])
                ->setPrGaz($infos['prGaz'])
                ->setPrAbonnParMois($infos['prAbonnParMois'])
                ->setFournisseur($_POST['fournisseur'])
                ->setDureEnMois($_POST['dureEnMois'])
                ->setCta($infos['cta'])
                ->setStatut('created');
            $this->em->persist($detailleoffreGaz);
            $this->em->flush();

            $budget = new BudgetGaz();
            $budget->setAbonnementParAn($infos['prAbonnParMois']*12)
                ->setTermeProportionnelparAn($infos['prGaz']*$CAR)
                ->setTermededistributionparAn($infos['prGaz']*$infos['tqa'])
                ->setTotalTaxeshorsTVAparAn(($infos['prAbonnParMois']*12)+($infos['prGaz']*$CAR))
                ->setCTAparan($infos['cta']*12)
                ->setTICGNparan($CAR *8.44)
                ->setCEEparan($infos['cee']*$CAR)
                ->setTOTALBUDGETANNUELTTCouCTRS($budget->getTotalTaxeshorsTVAparAn()+$budget->getCTAparan()+$budget->getTICGNparan())
                ->setDetailleOffreGaz($detailleoffreGaz)
            ;
            $totalSurCotrat = ($dureEnMois/12)*$budget->getTOTALBUDGETANNUELTTCouCTRS();
            $budget->setTotalsurladureducontrat($totalSurCotrat);
            $a = ((($budget->getAbonnementParAn()*5.5)/100)+$budget->getAbonnementParAn()) +((($budget->getTermeProportionnelparAn()*20)/100)+$budget->getTermeProportionnelparAn());
            $budget->setTotalTaxeshorsTVAparAnTTC($a);
            $b = (($infos['cta']*12)*5.5/100)+($infos['cta']*12);
            $c = (($CAR *8.44)*20/100)+($CAR *8.44);
            $d = (($infos['cee']*$CAR)*20/100)+($infos['cee']*$CAR);
            $budget->setBudgetTTC($a+$b+$c+$d);
            // dd($a.'/'.$b.'/'.$c.'/'.$d);
            $c = (($dureEnMois/12)*$budget->getBudgetTTC());
            $budget->setTotalsurladureducontratenTTC($c);
            $budgetCible = $objectifRepository->findBy(['user'=>$detailleoffreGaz->getOffre()->getClient(), 'perimetre'=>'gaz']);
            $cible = $budgetCible[sizeof($budgetCible) - 1];
            $voir = $request->get('voir');
            if(isset($voir)){

            }else{
                $this->em->persist($detailleoffreGaz);
                $this->em->flush();
                return $this->redirectToRoute('detailleOffreGaz',['id'=>$offreGaz->getId()]);
            }
            $ecart = (float)$budget->getBudgetTTC()>(float)$cible->getValeur() ? (float)$budget->getBudgetTTC()-(float)$cible->getValeur(): (float)$cible->getValeur() - (float)$budget->getBudgetTTC();
            return $this->render('admin/detailleOffreGaz.html.twig',[
                'form'=>$form->createView(),
                'offre'=>$offreGaz,
                'cible' => $cible,
                'budget' => $budget->getBudgetTTC(),
                'ecart' => $ecart,
                'id' => $offreGaz->getId()
            ]);
        }
        return $this->render('admin/detailleOffreGaz.html.twig',['form'=>$form->createView(), 'offre'=>$offreGaz, 'id' => $offreGaz->getId()]);
    }

    /**
     * @Route("/showdetailleOffreGazs-{id}.html", name="showdetailleOffreGazs")
     * @param OffreGaz $offreGaz
     * @return Response
     */
    public function showdetailleOffreGazs(OffreGaz $offreGaz)
    {
        return $this->render('admin/showdetailleOffreGazs.html.twig',['offrgaz'=>$offreGaz]);
    }
}