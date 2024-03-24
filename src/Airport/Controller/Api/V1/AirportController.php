<?php

declare(strict_types=1);

namespace App\Airport\Controller\Api\V1;

use App\Airport\Action\Create\CreateAirportActionInterface;
use App\Airport\Action\Create\CreateAirportActionRequest;
use App\Airport\Action\Delete\DeleteAirportActionInterface;
use App\Airport\Action\Delete\DeleteAirportActionRequest;
use App\Airport\Action\Get\GetAirportsActionInterface;
use App\Airport\Action\Get\GetAirportsActionRequest;
use App\Airport\Action\Query\QueryAirportsActionInterface;
use App\Airport\Action\Query\QueryAirportsActionRequest;
use App\Airport\Action\Update\UpdateAirportActionInterface;
use App\Airport\Action\Update\UpdateAirportActionRequest;
use App\Airport\Controller\Response\AirportResponse;
use App\Airport\Controller\Response\QueryChildrenAirportResponse;
use App\Application\Controller\Api\ApiController;
use App\Application\Controller\HttpMethod;
use App\Application\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;

#[OA\Tag(name: 'Airports')]
class AirportController extends ApiController
{
    public const API_ROUTE = '/api/v1/airports';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_airport_api_v1_airport_create', methods: HttpMethod::POST)]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: CreateAirportActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Airport created successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: AirportResponse::class)
        )
    )]
    public function create(Request $request, CreateAirportActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateAirportActionRequest::class);
        return $this->json($action->run($req)->airport);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_airport_api_v1_airport_update', methods: HttpMethod::PUT)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Airport uuid'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: UpdateAirportActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Airport updated successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: AirportResponse::class)
        )
    )]
    public function update(string $id, Request $request, UpdateAirportActionInterface $action): JsonResponse
    {
        /** @var UpdateAirportActionRequest $req */
        $req = $this->handleRequest($request, UpdateAirportActionRequest::class);
        return $this->json($action->run($req, Uuid::fromString($id))->airport);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_airport_api_v1_airport_delete', methods: HttpMethod::DELETE)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Airport uuid'
    )]
    #[OA\Response(
        response: 200,
        description: 'Airport deleted successfully.',
    )]
    public function delete(string $id, DeleteAirportActionInterface $action): JsonResponse
    {
        $req = new DeleteAirportActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{query}', name: 'app_airport_api_v1_airport_query', methods: HttpMethod::GET)]
    #[OA\Parameter(
        name: 'query',
        in: 'path',
        required: true,
        description: 'Query string to search airports by title, IATA, ICAO, city or country.'
    )]
    #[OA\Response(
        response: 200,
        description: 'List of airports.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: QueryChildrenAirportResponse::class))
        )
    )]
    public function query(Request $request, string $query, QueryAirportsActionInterface $queryAction): JsonResponse
    {
        $req = QueryAirportsActionRequest::fromArray($request->query->all(), $query);
        $this->validateRequest($req);
        return $this->json($queryAction->run($req)->airports);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_airport_api_v1_airport_list', methods: HttpMethod::GET)]
    #[OA\Parameter(name: 'limit', in: 'query', required: false, description: 'Default 500')]
    #[OA\Parameter(name: 'offset', in: 'query', required: false, description: 'Default 0')]
    #[OA\Parameter(name: 'id', in: 'query', required: false, description: 'Airprot uuid')]
    #[OA\Parameter(name: 'title', in: 'query', required: false, description: 'Airport title')]
    #[OA\Parameter(name: 'iata', in: 'query', required: false, description: 'Airport IATA code')]
    #[OA\Parameter(name: 'icao', in: 'query', required: false, description: 'Airport ICAO code')]
    #[OA\Parameter(name: 'cityTitle', in: 'query', required: false, description: 'City title')]
    #[OA\Parameter(name: 'timezone', in: 'query', required: false, description: 'Timezone (e.g. Europe/Oslo)')]
    #[OA\Parameter(name: 'isActive', in: 'query', required: false, description: 'Is active (true/false)')]
    #[OA\Response(
        response: 200,
        description: 'List of airports.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: AirportResponse::class))
        )
    )]
    public function list(Request $request, GetAirportsActionInterface $getAction): JsonResponse
    {
        $req = GetAirportsActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);
        return $this->json($getAction->run($req)->airports);
    }
}
