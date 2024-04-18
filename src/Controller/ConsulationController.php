<?php

namespace App\Controller;

use App\Entity\Consultaion;
use App\Entity\Specialite;
use App\Form\ConsEditFormType;
use App\Form\SpecEditFormType;
use App\Form\SpecialiteFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ConsultaionRepository;
use App\Repository\SpecialiteRepository;
use Symfony\Component\HttpFoundation\Request;

class ConsulationController extends AbstractController
{
    /* FUNCTIONS CONSULTATION */
    #[Route('/admin', name: 'app_admin')]
    public function index(ConsultaionRepository $consultaionRepository): Response
    {
        return $this->render('admin.html.twig', [
            'cons' => $consultaionRepository->findAll(),
        ]);
    }
    #[Route('/consedit/{id}', name: 'app_admin_consedit')]
    public function EditCons($id, ConsultaionRepository $consultaionRepository, Request $request): Response
    {
        $coninfo = $consultaionRepository->find($id);
        $form = $this->createForm(ConsEditFormType::class, $coninfo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
        }
        return $this->render('ConsEdit/ConsEdit.html.twig', [
            'form' => $form->createView(),
            'cinfo' => $coninfo
        ]);
    }
    #[Route('/consadmin/{id}', name: 'app_admin_conssupp')]
    public function SuppCons($id): Response
    {
        $cons = $this->getDoctrine()->getRepository(Consultaion::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($cons);
        $em->flush();
        return $this->redirectToRoute('app_admin');
    }
    /* FUNCTIONS SPECIALITE */
    #[Route('/adminspecialite', name: 'app_admin_spec')]
    public function adminspecialite(Request $request, SpecialiteRepository $specialiteRepository): Response
    {
        $specialite = new Specialite();
        $form = $this->createForm(SpecialiteFormType::class, $specialite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($specialite);
            $entityManager->flush();
        }
        return $this->render('adminspec.html.twig', [
            'form' => $form->createView(),
            'specs' => $specialiteRepository->findAll(),
        ]);
    }
    #[Route('/specedit/{id}', name: 'app_admin_specedit')]
    public function EditSpec($id, SpecialiteRepository $specialiteRepository, Request $request): Response
    {
        $specinfo = $specialiteRepository->find($id);
        if (!$specinfo) {
            throw $this->createNotFoundException('No specialite found for id ' . $id);
        }

        $form = $this->createForm(SpecEditFormType::class, $specinfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // Entity manager tracks changes made to $specinfo by the form
            $entityManager->flush();

            $this->addFlash('message', 'Specialite modifié avec succès');
            return $this->redirectToRoute('app_admin_spec');
        }

        return $this->render('ConsEdit/SpecEdit.html.twig', [
            'form' => $form->createView(),
            'sinfo' => $specinfo
        ]);
    }
    #[Route('/specadmin/{id}', name: 'app_admin_specsupp')]
    public function SuppSpec($id): Response
    {
        $spec = $this->getDoctrine()->getRepository(Specialite::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($spec);
        $em->flush();
        return $this->redirectToRoute('app_admin_spec');
    }
}
