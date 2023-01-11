<?php

declare(strict_types=1);

namespace App\Airport\Controller\Api\V1;

use App\Airport\Action\Create\CreateAirportActionInterface;
use App\Airport\Action\Create\CreateAirportActionRequest;
use App\Airport\Action\Delete\DeleteAirportActionInterface;
use App\Airport\Action\Delete\DeleteAirportActionRequest;
use App\Airport\Action\Get\GetAirportsActionInterface;
use App\Airport\Action\Get\GetAirportsActionRequest;
use App\Airport\Action\Update\UpdateAirportActionInterface;
use App\Airport\Action\Update\UpdateAirportActionRequest;
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

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_airport_api_v1_airport_update', methods: HttpMethod::PUT)]
    public function update(string $id, Request $request, UpdateAirportActionInterface $action): JsonResponse
    {
        /** @var UpdateAirportActionRequest $req */
        $req = $this->handleRequest($request, UpdateAirportActionRequest::class);
        $req->setId($id);
        return $this->json($action->run($req)->airport);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_airport_api_v1_airport_delete', methods: HttpMethod::DELETE)]
    public function delete(string $id, DeleteAirportActionInterface $action): JsonResponse
    {
        $req = new DeleteAirportActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_airport_api_v1_airport_list', methods: HttpMethod::GET)]
    public function list(Request $request, GetAirportsActionInterface $action): JsonResponse
    {
        $req = GetAirportsActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);
        return $this->json($action->run($req)->airports);
    }
}