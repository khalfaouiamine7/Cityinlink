<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Pharmacie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface; // Importez la SessionInterface

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'pharmacie_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $repository = $entityManager->getRepository(Pharmacie::class);
        $pharmacies = $repository->findAll();

        // Récupérer le thème de la session ou utiliser 'light' comme valeur par défaut
        $theme = $session->get('theme', 'light');

        return $this->render('home.html.twig', [
            'pharmacies' => $pharmacies,
            'theme' => $theme // Passer la préférence de thème au template
        ]);
    }
}
