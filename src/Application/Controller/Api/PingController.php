<?php

declare(strict_types=1);

namespace App\Application\Controller\Api;

use App\Application\Controller\HttpMethod;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Server')]
class PingController
{
    #[Route('/api/ping', name: 'ping', methods: HttpMethod::GET)]
    #[OA\Response(
        response: 200,
        description: 'Airport updated successfully.',
        content: new OA\JsonContent(
            type: 'object',
            example: ['message' => 'pong']
        )
    )]
    public function ping(): JsonResponse
    {
        return new JsonResponse(['message' => 'pong']);
    }
}
