<?php

declare(strict_types=1);

namespace App\Application\EventListener;

use App\Application\Exception\ApplicationException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\BaseException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;

readonly class ExceptionListener
{
    private const SKIP_LOG_EXCEPTIONS = [
        NotFoundHttpException::class,
        MethodNotAllowedHttpException::class,
        BaseException::class,
    ];

    public function __construct(
        private LoggerInterface $logger,
        private KernelInterface $kernel,
        private Environment $twig,
    ) {}

    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $event->getRequest();
        $e = $event->getThrowable();

        $code = $e->getPrevious() ? $e->getPrevious()->getCode() : $e->getCode();

        if ($code === 0 & $e->getMessage() === 'Syntax error' && str_contains($request->getPathInfo(), 'api')) {
            $event->setResponse(new JsonResponse(['error' => 'Invalid json string'], 400));
            return;
        }

        if ($code < 100) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $message = $code > 499 ? 'Internal service error.' : $e->getMessage();

        if ($e instanceof ApplicationException || $this->kernel->getEnvironment() === 'dev') {
            $message = $e->getMessage();
        } else {
            $response = new JsonResponse(['error' => $message]);
            $response->setStatusCode($code > 599 ? Response::HTTP_INTERNAL_SERVER_ERROR : $code);
        }

        if (strpos($request->getPathInfo(), '/admin') === 0) {
            $content = $this->twig->render(
                'admin/error.html.twig',
                [
                    'message' => $e instanceof BaseException
                        ? $this->getAdminMessage($e)
                        : $e->getMessage()
                ]
            );

            $code = $e instanceof BaseException ? $e->getStatusCode() : $code;

            $response = new Response($content, $code > 499 ? Response::HTTP_INTERNAL_SERVER_ERROR : $code);
            $event->setResponse($response);
            return;
        } else {
            $response = new JsonResponse(['error' => $message]);
            $response->setStatusCode($code > 599 ? Response::HTTP_INTERNAL_SERVER_ERROR : $code);
        }

        if (!in_array(get_class($e), self::SKIP_LOG_EXCEPTIONS)) {
            if ($code > 499) {
                $this->logger->error($e->getMessage() . "\n" .  $e->getTraceAsString());
            }
        }

        $event->setResponse($response);
    }

    private function getAdminMessage(BaseException $e): string
    {
        return match ($e->getPublicMessage()) {
            'exception.entity_not_found' => 'This item is not found.',
            'exception.entity_remove' => 'This item can\'t be deleted because other items depend on it.',
            'exception.forbidden_action' => 'The requested action can\'t be performed on this item.',
            'exception.insufficient_entity_permission' => 'You don\'t have permission to access this item.',
            default => 'Something went wrong'
        };
    }
}
