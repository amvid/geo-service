<?php

declare(strict_types=1);

namespace App\Airport\Controller\Api\V1;

use App\Airport\Action\Create\CreateAirportActionInterface;
use App\Airport\Action\Create\CreateAirportActionRequest;
use App\Application\Controller\Api\ApiController;
use App\Application\Controller\HttpMethod;
use App\Application\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AirportController extends ApiController
{
    private const API_ROUTE = '/api/v1/airports';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_airport_api_v1_airport_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateAirportActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateAirportActionRequest::class);
        return $this->json($action->run($req)->airport);
    }
}