<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use App\Entity\Evenement;

class PdfGeneratorController extends AbstractController
{
    #[Route('/pdf/generator/{id}', name: 'app_pdf_generator')]
    public function index(EntityManagerInterface $entityManager, $id): Response
    {
        $evenement = $entityManager->getRepository(Evenement::class)->find($id);

        $data = [
            'imageSrc'  => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/uploads/images/' . $evenement->getImage()),
            'Nom'         => $evenement->getNom(),
            'description'      => $evenement->getDescription(),
            'date' => $evenement->getDateE()->format('Y-m-d'),
        ];
        $html = $this->renderView('pdf_generator/index.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response (
            $dompdf->output(),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    private function imageToBase64($path) {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}
