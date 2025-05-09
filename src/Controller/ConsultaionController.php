<?php

namespace App\Controller;

use App\Entity\Consultaion;
use App\Form\ConsultaionType;
use App\Repository\ConsultaionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/consultaion')]
class ConsultaionController extends AbstractController
{
    #[Route('/', name: 'app_consultaion_index', methods: ['GET'])]
    public function index(Request $request,ConsultaionRepository $consultaionRepository,PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get('search');

        if ($searchTerm) {
            $consultaions = $consultaionRepository->findBySearchTerm($searchTerm);
        } else {
            $consultaions = $consultaionRepository->findAll();
        }

        return $this->render('consultaion/index.html.twig', [
            'consultaions' => $consultaions,
        ]);
    }
    #[Route('/sort', name: 'app_sortt', methods: ['GET'])]
    public function sort(Request $request, ConsultaionRepository $consultaionRepository): Response
    {
        $criteria = $request->query->get('criteria', 'nom');
        $direction = $request->query->get('direction', 'asc');
    
        $consultaions = $consultaionRepository->findBy([], [$criteria => $direction]);
    
        return $this->render('consultaion/index.html.twig', [
            'consultaions' => $consultaions,
        ]);
    }

    #[Route('/new', name: 'app_consultaion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $consultaion = new Consultaion();
        $form = $this->createForm(ConsultaionType::class, $consultaion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($consultaion);
            $entityManager->flush();

            return $this->redirectToRoute('app_consultaion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consultaion/new.html.twig', [
            'consultaion' => $consultaion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consultaion_show', methods: ['GET'])]
    public function show(Consultaion $consultaion): Response
    {
        return $this->render('consultaion/show.html.twig', [
            'consultaion' => $consultaion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_consultaion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Consultaion $consultaion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConsultaionType::class, $consultaion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_consultaion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consultaion/edit.html.twig', [
            'consultaion' => $consultaion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consultaion_delete', methods: ['POST'])]
    public function delete(Request $request, Consultaion $consultaion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultaion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($consultaion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_consultaion_index', [], Response::HTTP_SEE_OTHER);
    }
    private function isRecaptchaValid($recaptchaResponse)
    {
        $secretKey = '6LdgqIgpAAAAAIL7zt1gZh87stU7vGsgR3Yl7h7X';
        $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $postData = http_build_query([
            'secret' => $secretKey,
            'response' => $recaptchaResponse
        ]);

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postData
            ]
        ]);

        $response = file_get_contents($recaptchaUrl, false, $context);
        $result = json_decode($response);

        return $result->success;
    }
}
