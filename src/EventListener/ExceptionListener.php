<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ApplicationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

readonly class ExceptionListener
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if ($e instanceof ApplicationException) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } else {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = 'Internal service error.';
            $this->logger->error($message);
        }

        $response = new JsonResponse();
        $response->setContent($message);
        $response->setStatusCode($code);

        $event->setResponse($response);
    }
}