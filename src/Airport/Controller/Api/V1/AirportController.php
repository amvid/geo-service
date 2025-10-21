<?php

declare(strict_types=1);

namespace App\Airport\Controller\Api\V1;

use App\Airport\Action\Create\CreateAirportActionInterface;
use App\Airport\Action\Create\CreateAirportActionRequest;
use App\Airport\Action\Delete\DeleteAirportActionInterface;
use App\Airport\Action\Delete\DeleteAirportActionRequest;
use App\Airport\Action\Get\GetAirportsActionInterface;
use App\Airport\Action\Get\GetAirportsActionRequest;
use App\Airport\Action\GetAirportsByIataCodes\GetAirportsByIataCodesActionInterface;
use App\Airport\Action\Query\QueryAirportsActionInterface;
use App\Airport\Action\Query\QueryAirportsActionRequest;
use App\Airport\Action\Update\UpdateAirportActionInterface;
use App\Airport\Action\Update\UpdateAirportActionRequest;
use App\Airport\Controller\Response\AirportResponse;
use App\Airport\Controller\Response\QueryChildrenAirportResponse;
use App\Application\Controller\Api\ApiController;
use App\Application\Controller\HttpMethod;
use App\Application\Exception\ValidationException;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Tag(name: 'Airports')]
class AirportController extends ApiController
{
    public const string API_ROUTE = '/api/v1/airports';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_airport_api_v1_airport_create', methods: HttpMethod::POST)]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: CreateAirportActionRequest::class),
            type: "object"
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Airport created successfully.',
        content: new OA\JsonContent(
            ref: new Model(type: AirportResponse::class),
            type: 'object'
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
        description: 'Airport uuid',
        in: 'path',
        required: true
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: UpdateAirportActionRequest::class),
            type: "object"
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Airport updated successfully.',
        content: new OA\JsonContent(
            ref: new Model(type: AirportResponse::class),
            type: 'object'
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
        description: 'Airport uuid',
        in: 'path',
        required: true
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

    #[Route(self::API_ROUTE . '/iata-codes', name: 'app_airport_api_v1_airport_get_by_iata_codes', methods: HttpMethod::GET)]
    #[OA\Parameter(
        name: 'query',
        description: 'Iata codes split by comma. E.g. FRA,RIX,TRD',
        in: 'query',
        required: true,
        example: 'FRA,RIX,TRD',
    )]
    #[OA\Response(
        response: 200,
        description: 'List of airports.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: AirportResponse::class))
        )
    )]
    public function getByIataCodes(Request $request, GetAirportsByIataCodesActionInterface $action): JsonResponse
    {
        $iataCodes = $request->get('query', '');
        $iataArray = $iataCodes ? array_map('trim', explode(',', $iataCodes)) : [];

        return $this->json($action->run($iataArray));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{query}', name: 'app_airport_api_v1_airport_query', methods: HttpMethod::GET)]
    #[OA\Parameter(
        name: 'query',
        description: 'Query string to search airports by title, IATA, ICAO, city or country.',
        in: 'path',
        required: true
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
    #[OA\Parameter(name: 'limit', description: 'Default 500', in: 'query', required: false, content: new OA\JsonContent(type: 'integer'))]
    #[OA\Parameter(name: 'offset', description: 'Default 0', in: 'query', required: false, content: new OA\JsonContent(type: 'integer'))]
    #[OA\Parameter(name: 'id', description: 'Airport uuid', in: 'query', required: false, content: new OA\JsonContent(type: 'string'))]
    #[OA\Parameter(name: 'title', description: 'Airport title', in: 'query', required: false, content: new OA\JsonContent(type: 'string'))]
    #[OA\Parameter(name: 'iata', description: 'Airport IATA code', in: 'query', required: false, content: new OA\JsonContent(type: 'string'))]
    #[OA\Parameter(name: 'icons', description: 'Airport ICAO code', in: 'query', required: false, content: new OA\JsonContent(type: 'string'))]
    #[OA\Parameter(name: 'cityTitle', description: 'City title', in: 'query', required: false, content: new OA\JsonContent(type: 'string'))]
    #[OA\Parameter(name: 'timezone', description: 'Timezone (e.g. Europe/Oslo)', in: 'query', required: false, content: new OA\JsonContent(type: 'string'))]
    #[OA\Parameter(name: 'isActive', description: 'Is active (true/false)', in: 'query', required: false, content: new OA\JsonContent(type: 'boolean'))]
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
