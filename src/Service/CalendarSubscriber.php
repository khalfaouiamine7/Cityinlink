<?php

namespace App\Service;

use App\Repository\ConsultaionRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $consultaionRepository; // Corrected variable name

    private $router; // Corrected variable name

    public function __construct(ConsultaionRepository $consultaionRepository, UrlGeneratorInterface $router)
    {
        $this->consultaionRepository = $consultaionRepository;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();
        $cons = $this->consultaionRepository
            ->createQueryBuilder('consultaion')
            ->where('consultaion.date BETWEEN :start and :end OR consultaion.endAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;
        foreach ($cons as $con) {
            $ConEvent = new Event(
                $con->getAdresse(),
                $con->getDate(),
                $con->getEndAt()
            );
            $ConEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            $calendar->addEvent($ConEvent);
        }
    }
}
