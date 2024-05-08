<?php

// src/Controller/ReclamationController.php
namespace App\Controller;

use App\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ReclamationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Création et envoi de l'email
            $email = (new Email())
                ->from($data['email'])
                ->to('your-email@example.com')
                ->subject('Réclamation pour ' . $data['pharmacyName'])
                ->text('Réclamation reçue : ' . $data['description']);

            $mailer->send($email);

            // Ajouter un message flash
            $this->addFlash('success', 'Votre réclamation a été envoyée.');

            return $this->redirectToRoute('app_reclamation');
        }

        return $this->render('reclamation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
