<?php

namespace App\Subscribers;

use App\Events\IncidenciaEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class IncidenciaSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            IncidenciaEvent::SAVED => 'enviarEmail'
        ];
    }

    public function enviarEmail(IncidenciaEvent $event)
    {
        echo 'Guardado '.$event->getIncidencia()->getTitulo();
    }
}