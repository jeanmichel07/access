<?php

namespace App\Controller;

use App\Entity\CompComptage;
use App\Entity\CompGestion;
use App\Entity\CompSoustiragePartFixe;
use App\Entity\CompSoustiragePartVariable;
use App\Form\CompComptageType;
use App\Form\CompGestionType;
use App\Form\CompSoustiragePartFixeType;
use App\Form\CompSoustiragePartVariableType;
use App\Repository\CompComptageRepository;
use App\Repository\CompGestionRepository;
use App\Repository\CompSoustiragePartFixeRepository;
use App\Repository\CompSoustiragePartVariableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SettingController
 * @package App\Controller
 * @Route("/admin")
 */
class SettingController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/setting", name="setting")
     */
    public function index(): Response
    {
        return $this->render('setting/index.html.twig', [
            'controller_name' => 'SettingController',
        ]);
    }

    /**
     * @param CompComptageRepository $repository
     * @return Response
     * @Route("/setting/comp-comptage", name="index_comptage")
     */
    public function indexCompComptage(CompComptageRepository $repository){
        $compComptage = $repository->findAll();
        return $this->render('setting/indexCompComptage.html.twig',[
            'com' => $compComptage
        ]);
    }

    /**
     * @Route("/setting/edit-comp-comptage/{id}", name="edit_comptage")
     * @param CompComptage $compComptage
     * @return Response
     */
    public function editCompComptage(CompComptage $compComptage, Request $request){
        $form = $this->createForm(CompComptageType::class, $compComptage)->remove('segmentation');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($compComptage);
            $this->manager->flush();

            return $this->redirectToRoute("index_comptage");
        }
        return $this->render('setting/manageCompComposant.html.twig',[
            'form' => $form->createView(),
            'c'=>$compComptage
        ]);
    }

    /**
     * @param CompGestionRepository $repository
     * @return Response
     * @Route("/setting/comp-gestion", name="index_gestion")
     */
    public function indexCompGestion(CompGestionRepository $repository){
        $compGestion = $repository->findAll();
        return $this->render('setting/indexCompGestion.html.twig',[
            'com' => $compGestion
        ]);
    }

    /**
     * @Route("/setting/edit-comp-gestion/{id}", name="edit_getsion")
     * @param CompGestion $compGestion
     * @return Response
     */
    public function editCompGestion(CompGestion $compGestion, Request $request){
        $form = $this->createForm(CompGestionType::class, $compGestion)->remove('segmentation');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($compGestion);
            $this->manager->flush();

            return $this->redirectToRoute("index_gestion");
        }
        return $this->render('setting/manageCompGestion.html.twig',[
            'form' => $form->createView(),
            'c'=>$compGestion
        ]);
    }

    /**
     * @Route("/setting/index-comp/part-fixe", name ="indexPartFixe")
     */
    public function indexCompPartFixe(CompSoustiragePartFixeRepository $repository){
        $compPartFixe = $repository->findAll();
        return $this->render('setting/partFixe.html.twig',[
            'partFixe' => $compPartFixe
        ]);
    }

    /**
     * @Route("/setting/edit-comp/part-fixe/{id}", name ="editPartFixe")
     * @param CompSoustiragePartFixe $compSoustiragePartFixe
     * @param Request $request
     */
    public function editCompPartFixe(CompSoustiragePartFixe $compSoustiragePartFixe, Request $request){
        $form = $this->createForm(CompSoustiragePartFixeType::class, $compSoustiragePartFixe)->remove('segmentation');

        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $this->manager->persist($compSoustiragePartFixe);
            $this->manager->flush();
            return $this->redirectToRoute('indexPartFixe');
        }
        return $this->render('setting/manageCompPartFixe.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/setting/index-comp/part-variable", name ="indexPartVariable")
     */
    public function indexCompPartVariable(CompSoustiragePartVariableRepository $repository){
        $compPartVariable = $repository->findAll();
        return $this->render('setting/partVariable.html.twig',[
            'partVariable' => $compPartVariable
        ]);
    }

    /**
     * @Route("/setting/edit-comp/part-variable/{id}", name ="editPartVariable")
     * @param CompSoustiragePartVariable $compSoustiragePartVariable
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editCompPartVariable(CompSoustiragePartVariable $compSoustiragePartVariable, Request $request){
        $form = $this->createForm(CompSoustiragePartVariableType::class, $compSoustiragePartVariable)->remove('segmentation');

        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $this->manager->persist($compSoustiragePartVariable);
            $this->manager->flush();
            return $this->redirectToRoute('indexPartVariable');
        }
        return $this->render('setting/manageCompPartVariable.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
