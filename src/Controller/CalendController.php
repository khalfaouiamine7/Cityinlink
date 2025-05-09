<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ConsultaionRepository;

class CalendController extends AbstractController
{
    #[Route('/calend', name: 'app_calend')]
    public function index(ConsultaionRepository $consultaionRepository): Response
    {
    
        $events = $consultaionRepository->findAll();
        $rdvs = [];
        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getDate()->format('Y-m-d H:i:s'),
                'title' => $event->getAdresse(),
                'description' => $event->getSpecialite(),
                'backgroundColor' =>'#ff6969',
                'borderColor' => '#697a8d',
                'textColor' => '#697a8d'
            ];
        }
        $data = json_encode($rdvs);
        dump($data);

        return $this->render('calend/index.html.twig', compact('data'));
    }

}
