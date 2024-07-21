<?php

declare(strict_types=1);

namespace App\Application\EventListener;

use App\Application\Exception\ApplicationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelInterface;

readonly class ExceptionListener
{
    public function __construct(
        private LoggerInterface $logger,
        private KernelInterface $kernel,
    ) {}

    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if ($e instanceof ApplicationException || $this->kernel->getEnvironment() === 'dev') {
            $code = $e->getCode() === 0 ? Response::HTTP_INTERNAL_SERVER_ERROR : $e->getCode();
            $message = $e->getMessage();
        } else {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = 'Internal service error.';
            $this->logger->error($message);
        }

        $response = new JsonResponse();
        $response->setContent(json_encode(['error' => $message]));
        $response->setStatusCode($code);

        $event->setResponse($response);
    }
}
