<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\DetailleOffreGaz;
use App\Entity\DetailOffreElec;
use App\Entity\OffreElectricite;
use App\Entity\OffreGaz;
use App\Form\PassClientType;
use App\Repository\InfoSuplementaireElecRepository;
use App\Repository\InfoSuplementaireGazRepository;
use App\Repository\ObjectifRepository;
use App\Repository\OffreElectriciteRepository;
use App\Repository\OffreGazRepository;
use App\Repository\PerimetreElectriciteRepository;
use App\Repository\PermetreGazRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ClientController
 * @package App\Controller
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/accueil.html", name="client")
     */
    public function index(OffreElectriciteRepository $repository, OffreGazRepository $gazRepository): Response
    {
        $client = $this->getUser();
        $elec = $repository->findFive($client);
        $gaz = $gazRepository->findFive($client);
        return $this->render('client/index.html.twig',[
            'elec'=>$elec,
            'gaz'=>$gaz,
            'client'=>$client
        ]);
    }
    /**
     * @Route("/historique.html", name="historiqueD")
     */
    public function historique(OffreElectriciteRepository $repository, OffreGazRepository $gazRepository): Response
    {
        $client = $this->getUser();
        $elec = $repository->findAlls($client);
        $gaz = $gazRepository->findAlls($client);
        return $this->render('client/historique.html.twig',[
            'elec'=>$elec,
            'gaz'=>$gaz,
            'client'=>$client
        ]);
    }

    /**
     * @Route("/perimetre-electricite.html", name="perimetreElec")
     */
    public function showPerimElec(){
        $client = $this->getUser();
        return $this->render('client/perimElec.html.twig',[
            'c'=>$client
        ]);
    }
    /**
     * @Route("/perimetre-gaz.html", name="perimetreGaz")
     */
    public function showPerimGaz(){
        $client = $this->getUser();
        return $this->render('client/perimGaz.html.twig',[
            'c'=>$client
        ]);
    }
    /**
     * @param OffreElectricite $offreElectricite
     * @return Response
     * @Route("/historique/detail-{id}.html", name = "detailhistoriqueclient")
     */
    public function detailHistoriqueElec(OffreElectricite $offreElectricite, InfoSuplementaireElecRepository $repository, ObjectifRepository $objectifRepository){
        $objectif = $objectifRepository->findObjectElec($offreElectricite->getClient(), 'elec');
        $objectifElec = $objectif->getValeur();
        $infoSupliElec = $repository->findByOffreElec($offreElectricite);
        return $this->render('client/detailhistorique.html.twig',[
            'elec'=>$offreElectricite,
            'info'=>$infoSupliElec[0] != null ? $infoSupliElec[0] : [0],
            'objectif'=>$objectifElec
        ]);
    }

    /**
     * @param OffreElectricite $offreElectricite
     * @return Response
     * @Route("/historique/detailgaz-{id}.html", name = "detailhistoriquegazclient")
     */
    public function detailHistoriqueGaz(OffreGaz $offreGaz, InfoSuplementaireGazRepository $repository, ObjectifRepository $objectifRepository){
        $infoSupliElec = $repository->findByOffreGaz($offreGaz);

        $objectif = $objectifRepository->findObjectElec($offreGaz->getClient(), 'gaz');
        $objectifGaz = $objectif->getValeur();
        return $this->render('client/detailhistoriqueGaz.html.twig',[
            'gaz'=>$offreGaz,
            'info'=>$infoSupliElec[0],
            'objectif'=>$objectifGaz
        ]);
    }

    /**
     * @Route("/validerElec{id}.html", name="validerelec")
     * @param DetailOffreElec $detailOffreElec
     * @return RedirectResponse
     */
    public function validerElec(DetailOffreElec $detailOffreElec, PerimetreElectriciteRepository $repository){
        $detailOffreElec->setStatut('accepte');
        $this->em->persist($detailOffreElec);

        $offreele = $detailOffreElec->getOffre();
        $client = $offreele->getClient();

        $segmantation = $offreele->getSegmentation();

        $nbrAccepted = $offreele->getNbrAccepted() + 1;
        $purcentage =($nbrAccepted * 100)/$offreele->getNbrOffre();
        $offreele->setNbrAccepted($nbrAccepted)
            ->setStatus('Offre accpetée');
        $this->em->persist($offreele);

        $perimetre = $repository->findByPerimElec($client, $segmantation);
        foreach ($perimetre as $p){
            $p->setStatut('Finalisé');
            $this->em->persist($p);
        }
        $client->setStatut('Finalisé');

        $this->em->persist($client);

        $this->em->flush();

        return $this->redirectToRoute('detailhistoriqueclient',['id'=>$detailOffreElec->getOffre()->getId()]);
    }

    /**
     * @Route("/validerGaz{id}.html", name="validereGaz")
     * @param DetailleOffreGaz $detailleOffreGaz
     * @param PermetreGazRepository $repository
     * @return RedirectResponse
     */
    public function validerGaz(DetailleOffreGaz $detailleOffreGaz, PermetreGazRepository $repository){
        $detailleOffreGaz->setStatut('accepte');
        $this->em->persist($detailleOffreGaz);

        $offreGaz = $detailleOffreGaz->getOffre();
        $client = $offreGaz->getClient();

        $profil = $offreGaz->getProfil();

        $perimetre = $repository->findByPerimGaz($client, $profil);

        foreach ($perimetre as $p){
            $p->setStatut('Finalisé');
            $this->em->persist($p);
        }

        $nbrAccepted = $offreGaz->getNbrAccepted() + 1;
        $purcentage =($nbrAccepted * 100)/$offreGaz->getNbrOffre();
        $offreGaz->setNbrAccepted($nbrAccepted)
            ->setStatus('Offre accpetée');
        $this->em->persist($offreGaz);

        $client->setStatut('Finalisé');

        $this->em->persist($client);
        $this->em->flush();

        return $this->redirectToRoute('detailhistoriquegazclient',['id'=>$detailleOffreGaz->getOffre()->getId()]);
    }

    /**
     * @Route("/DeclineElec{id}.html", name="Declineelec")
     * @param DetailOffreElec $detailOffreElec
     * @return RedirectResponse
     */
    public function DeclineElec(DetailOffreElec $detailOffreElec, PerimetreElectriciteRepository $repository){
        $detailOffreElec->setStatut('decline');
        $this->em->persist($detailOffreElec);

        $offreele = $detailOffreElec->getOffre();
        $client = $offreele->getClient();

        $segmantation = $offreele->getSegmentation();

        $nbrDeclined = $offreele->getNbrDeclined() + 1;
        $purcentage =($nbrDeclined * 100)/$offreele->getNbrOffre();
        $offreele->setNbrDeclined($nbrDeclined)
            ->setStatus('Offre déclinée');
        $this->em->persist($offreele);

        $perimetre = $repository->findByPerimElec($client, $segmantation);
        foreach ($perimetre as $p){
            $p->setStatut('Décliné');
            $this->em->persist($p);
        }
        $client->setStatut('Déclinée');

        $this->em->persist($client);

        $this->em->flush();

        return $this->redirectToRoute('detailhistoriqueclient',['id'=>$detailOffreElec->getOffre()->getId()]);
    }

    /**
     * @Route("/declineGaz{id}.html", name="declineGaz")
     * @param DetailleOffreGaz $detailleOffreGaz
     * @param PermetreGazRepository $repository
     * @return RedirectResponse
     */
    public function declineGaz(DetailleOffreGaz $detailleOffreGaz, PermetreGazRepository $repository){
        $detailleOffreGaz->setStatut('decline');
        $this->em->persist($detailleOffreGaz);

        $offreGaz = $detailleOffreGaz->getOffre();
        $client = $offreGaz->getClient();

        $profil = $offreGaz->getProfil();

        $perimetre = $repository->findByPerimGaz($client, $profil);

        foreach ($perimetre as $p){
            $p->setStatut('Decliné');
            $this->em->persist($p);
        }

        $nbrDecliné = $offreGaz->getNbrDeclined() + 1;
        $purcentage =($nbrDecliné * 100)/$offreGaz->getNbrOffre();
        $offreGaz->setNbrAccepted($nbrDecliné)
            ->setStatus('Offre Decliné');
        $this->em->persist($offreGaz);

        $client->setStatut('Decliné');

        $this->em->persist($client);
        $this->em->flush();

        return $this->redirectToRoute('detailhistoriquegazclient',['id'=>$detailleOffreGaz->getOffre()->getId()]);
    }
    /**
     * @Route("/edit.password.{id}", name="editPassword_client")
     */
    public function EditPassword(Client $client, UserPasswordEncoderInterface $encoder, Request $request){
        $form = $this->createForm(PassClientType::class, $client);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $password = $encoder->encodePassword($client, $client->getPassword());
            $client->setPassword($password);
            $this->em->persist($client);
            $this->em->flush();

            $this->addFlash('success', 'Votre mots de passe est bien modifié ');
        }
        return $this->render('client/password.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
