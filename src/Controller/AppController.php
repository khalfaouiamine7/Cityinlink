<?php

namespace App\Controller;
use App\Repository\ConsultaionRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ConsultationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Consultaion;
class AppController extends AbstractController
{
    #[Route('/', name: 'app_res')]
    public function index(Request $request,ConsultaionRepository $consultaionRepository): Response
    {
        $consultation = new Consultaion();
        $form = $this->createForm(ConsultationFormType::class, $consultation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consultation);
            $entityManager->flush();
        }
        return $this->render('index.html.twig', [
            'controller_name' => 'AppController',
            'form' => $form->createView(),
            'cons' => $consultaionRepository->findAll(),
        ]);
    }
}
