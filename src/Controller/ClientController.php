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
    const EMAIl = 'h.diakite@accessenergies.fr';

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
    public function validerElec(\Swift_Mailer $mailer ,DetailOffreElec $detailOffreElec, PerimetreElectriciteRepository $repository, Request $request){
        $contenu = $request->get('ac-raison');
        $detailOffreElec->setStatut('accepte');
        $this->em->persist($detailOffreElec);
        $offreele = $detailOffreElec->getOffre();
        $client = $offreele->getClient();
        $segmantation = $offreele->getSegmentation();
        $nbrAccepted = $offreele->getNbrAccepted() + 1;
        $purcentage =($nbrAccepted * 100)/$offreele->getNbrOffre();
        $offreele->setNbrAccepted($nbrAccepted)
            ->setStatus('Offre accpet??e');
        $this->em->persist($offreele);
        $perimetre = $repository->findByPerimElec($client, $segmantation);
        foreach ($perimetre as $p){
            $p->setStatut('Finalis??');
            $this->em->persist($p);
        }
        $client->setStatut('Finalis??');
        $this->em->persist($client);
        $this->em->flush();
        $message = (new \Swift_Message('Offre ??l??ctricit?? accept??'))
            ->setFrom($client->getEmail())
            ->setTo(self::EMAIl)
            ->setBody(
                $this->renderView(
                    'emails/refus.html.twig',[
                    'c' => $contenu,
                ]), 'text/html'
            );
        $mailer->send($message);
        return $this->redirectToRoute('detailhistoriqueclient',['id'=>$detailOffreElec->getOffre()->getId()]);
    }

    /**
     * @Route("/validerGaz{id}.html", name="validereGaz")
     * @param DetailleOffreGaz $detailleOffreGaz
     * @param PermetreGazRepository $repository
     * @return RedirectResponse
     */
    public function validerGaz(\Swift_Mailer $mailer, DetailleOffreGaz $detailleOffreGaz, PermetreGazRepository $repository, Request $request){
        $contenu = $request->get('ac-raison');
        $detailleOffreGaz->setStatut('accepte');
        $this->em->persist($detailleOffreGaz);
        $offreGaz = $detailleOffreGaz->getOffre();
        $client = $offreGaz->getClient();
        $profil = $offreGaz->getProfil();
        $perimetre = $repository->findByPerimGaz($client, $profil);
        foreach ($perimetre as $p){
            $p->setStatut('Finalis??');
            $this->em->persist($p);
        }
        $nbrAccepted = $offreGaz->getNbrAccepted() + 1;
        $purcentage = ($nbrAccepted * 100)/$offreGaz->getNbrOffre();
        $offreGaz->setNbrAccepted($nbrAccepted)
            ->setStatus('Offre accpet??e');
        $this->em->persist($offreGaz);
        $client->setStatut('Finalis??');
        $this->em->persist($client);
        $this->em->flush();

        $message = (new \Swift_Message('Offre gaz accept??'))
            ->setFrom($client->getEmail())
            ->setTo(self::EMAIl)
            ->setBody(
                $this->renderView(
                    'emails/refus.html.twig',[
                    'c' => $contenu,
                ]), 'text/html'
            );
        $mailer->send($message);

        return $this->redirectToRoute('detailhistoriquegazclient',['id'=>$detailleOffreGaz->getOffre()->getId()]);
    }

    /**
     * @Route("/DeclineElec{id}.html", name="Declineelec")
     * @param DetailOffreElec $detailOffreElec
     * @return RedirectResponse
     */
    public function DeclineElec(\Swift_Mailer $mailer, DetailOffreElec $detailOffreElec, PerimetreElectriciteRepository $repository, Request $request){
        $contenu = $request->get('dec-raison');
        $detailOffreElec->setStatut('decline');
        $this->em->persist($detailOffreElec);
        $offreele = $detailOffreElec->getOffre();
        $client = $offreele->getClient();
        $segmantation = $offreele->getSegmentation();
        $nbrDeclined = $offreele->getNbrDeclined() + 1;
        $purcentage =($nbrDeclined * 100)/$offreele->getNbrOffre();
        $offreele->setNbrDeclined($nbrDeclined)
            ->setStatus('Offre d??clin??e');
        $this->em->persist($offreele);
        $perimetre = $repository->findByPerimElec($client, $segmantation);
        foreach ($perimetre as $p){
            $p->setStatut('D??clin??');
            $this->em->persist($p);
        }
        $client->setStatut('D??clin??e');
        $this->em->persist($client);
        $this->em->flush();
        $message = (new \Swift_Message('Offre ??l??ctricit?? d??clin??'))
            ->setFrom($client->getEmail())
            ->setTo(self::EMAIl)
            ->setBody(
                $this->renderView(
                    'emails/refus.html.twig',[
                    'c' => $contenu,
                ]), 'text/html'
            );
        $mailer->send($message);

        return $this->redirectToRoute('detailhistoriqueclient',['id'=>$detailOffreElec->getOffre()->getId()]);
    }

    /**
     * @Route("/declineGaz{id}.html", name="declineGaz")
     * @param DetailleOffreGaz $detailleOffreGaz
     * @param PermetreGazRepository $repository
     * @return RedirectResponse
     */
    public function declineGaz(\Swift_Mailer $mailer,DetailleOffreGaz $detailleOffreGaz, PermetreGazRepository $repository, Request $request){
        $contenu = $request->get('dec-raison');

        $detailleOffreGaz->setStatut('decline');
        $this->em->persist($detailleOffreGaz);
        $offreGaz = $detailleOffreGaz->getOffre();
        $client = $offreGaz->getClient();
        $profil = $offreGaz->getProfil();
        $perimetre = $repository->findByPerimGaz($client, $profil);
        foreach ($perimetre as $p){
            $p->setStatut('Declin??');
            $this->em->persist($p);
        }
        $nbrDeclin?? = $offreGaz->getNbrDeclined() + 1;
        $purcentage =($nbrDeclin?? * 100)/$offreGaz->getNbrOffre();
        $offreGaz->setNbrAccepted($nbrDeclin??)
            ->setStatus('Offre Declin??');
        $this->em->persist($offreGaz);
        $client->setStatut('Declin??');
        $this->em->persist($client);
        $this->em->flush();

        $message = (new \Swift_Message('Offre gaz declin??'))
            ->setFrom($client->getEmail())
            ->setTo(self::EMAIl)
            ->setBody(
                $this->renderView(
                    'emails/refus.html.twig',[
                    'c' => $contenu,
                ]), 'text/html'
            );
        $mailer->send($message);

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

            $this->addFlash('success', 'Votre mots de passe est bien modifi?? ');
        }
        return $this->render('client/password.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
