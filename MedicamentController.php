<?php

namespace App\Controller;

use App\Entity\Medicament;
use App\Form\MedicamentType;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Writer\Result\PngResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/medicament')]
class MedicamentController extends AbstractController
{  
    
    #[Route('/', name: 'app_medicament_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository = $this->getDoctrine()->getRepository(Medicament::class);
        $medicaments = $repository->findAll();
    
        $totalMedicaments = count($medicaments);
        $countParacetamol = $repository->count(['type' => 'paracetamol']);
        $countAntibiotique = $repository->count(['type' => 'antibiotique']);
        $countAntiInflammatoire = $repository->count(['type' => 'anti-inflammatoire']);
    
        return $this->render('medicament/index.html.twig', [
            'medicaments' => $medicaments,
            'total_medicaments' => $totalMedicaments,
            'count_paracetamol' => $countParacetamol,
            'count_antibiotique' => $countAntibiotique,
            'count_anti_inflammatoire' => $countAntiInflammatoire,
        ]);
    }
    #[Route('/stat', name: 'app_medicament_stat', methods: ['GET'])]
    public function stat(EntityManagerInterface $entityManager): Response
    {
        $repository = $this->getDoctrine()->getRepository(Medicament::class);
        $medicaments = $repository->findAll();
    
        $totalMedicaments = count($medicaments);
        $countParacetamol = $repository->count(['type' => 'paracetamol']);
        $countAntibiotique = $repository->count(['type' => 'antibiotique']);
        $countAntiInflammatoire = $repository->count(['type' => 'anti-inflammatoire']);
    
        return $this->render('medicament/stat.html.twig', [
            'medicaments' => $medicaments,
            'total_medicaments' => $totalMedicaments,
            'count_paracetamol' => $countParacetamol,
            'count_antibiotique' => $countAntibiotique,
            'count_anti_inflammatoire' => $countAntiInflammatoire,
        ]);
    }

    #[Route('/new', name: 'app_medicament_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $medicament = new Medicament();
        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($medicament);
            $entityManager->flush();

            return $this->redirectToRoute('app_medicament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicament/new.html.twig', [
            'medicament' => $medicament,
            'form' => $form,
        ]);
    }

    // La méthode search a été ajoutée ici.
    #[Route('/search', name: 'app_medicament_search', methods: ['GET'])]
    public function search(Request $request, EntityManagerInterface $entityManager): Response
    {
        $searchTerm = $request->query->get('term', '');
        $medicaments = $entityManager->getRepository(Medicament::class)->findByTerm($searchTerm);

        return $this->render('medicament/index.html.twig', [
            'medicaments' => $medicaments,
        ]);
    }

    #[Route('/{idMedicament}', name: 'app_medicament_show', methods: ['GET'])]
    public function show(Medicament $medicament): Response
    {
        return $this->render('medicament/show.html.twig', [
            'medicament' => $medicament,
        ]);
    }

    #[Route('/{idMedicament}/edit', name: 'app_medicament_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Medicament $medicament, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_medicament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicament/edit.html.twig', [
            'medicament' => $medicament,
            'form' => $form,
        ]);
    }

    #[Route('/{idMedicament}', name: 'app_medicament_delete', methods: ['POST'])]
    public function delete(Request $request, Medicament $medicament, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medicament->getIdMedicament(), $request->request->get('_token'))) {
            $entityManager->remove($medicament);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_medicament_index', [], Response::HTTP_SEE_OTHER);
    }
}
