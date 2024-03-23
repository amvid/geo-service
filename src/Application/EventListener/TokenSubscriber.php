<?php

declare(strict_types=1);

namespace App\Application\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class TokenSubscriber implements EventSubscriberInterface
{
    private string $apiAuthToken;
    private bool $apiAuthEnabled;

    public function __construct(string $apiAuthToken, bool $apiAuthEnabled)
    {
        $this->apiAuthToken = $apiAuthToken;
        $this->apiAuthEnabled = $apiAuthEnabled;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (false === $this->apiAuthEnabled) {
            return;
        }

        $request = $event->getRequest();

        if (!str_starts_with($request->getPathInfo(), '/api/')) {
            return;
        }

        $token = $request->headers->get('Authorization');

        if ($token !== $this->apiAuthToken) {
            $event->setResponse(new JsonResponse(['error' => 'Invalid token'], 401));
        }
    }
}
