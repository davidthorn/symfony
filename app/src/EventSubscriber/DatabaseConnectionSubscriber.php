<?php

namespace App\EventSubscriber;

use Doctrine\DBAL\Exception\ConnectionException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 *
 */
class DatabaseConnectionSubscriber implements EventSubscriberInterface
{
    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        if($event->getThrowable() instanceof ConnectionException) {
            $error = $event->getThrowable();
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response
                ->setStatusCode(500)
                ->setContent(json_encode([
                    'code' => 500,
                    'message' => $error->getMessage()
                ]));
            $event->setResponse($response);
        }
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
