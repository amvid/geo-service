<?php

declare(strict_types=1);

namespace App\City\Controller\Api\V1;

use App\Application\Controller\Api\ApiController;
use App\Application\Controller\HttpMethod;
use App\Application\Exception\ValidationException;
use App\City\Action\Create\CreateCityActionInterface;
use App\City\Action\Create\CreateCityActionRequest;
use App\City\Action\Delete\DeleteCityActionInterface;
use App\City\Action\Delete\DeleteCityActionRequest;
use App\City\Action\Get\GetCitiesActionInterface;
use App\City\Action\Get\GetCitiesActionRequest;
use App\City\Action\Update\UpdateCityActionInterface;
use App\City\Action\Update\UpdateCityActionRequest;
use App\City\Controller\Response\CityResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;

#[OA\Tag(name: 'Cities')]
class CityController extends ApiController
{
    public const API_ROUTE = '/api/v1/cities';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_city_api_v1_city_create', methods: HttpMethod::POST)]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: CreateCityActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'City created successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: CityResponse::class)
        )
    )]
    public function create(Request $request, CreateCityActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateCityActionRequest::class);
        return $this->json($action->run($req)->city);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_city_api_v1_city_update', methods: HttpMethod::PUT)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'City uuid'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: UpdateCityActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'City updated successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: CityResponse::class)
        )
    )]
    public function update(string $id, Request $request, UpdateCityActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateCityActionRequest::class);
        return $this->json($action->run($req, Uuid::fromString($id))->city);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_city_api_v1_city_delete', methods: HttpMethod::DELETE)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'City uuid'
    )]
    #[OA\Response(
        response: 200,
        description: 'City deleted successfully.',
    )]
    public function delete(string $id, DeleteCityActionInterface $action): JsonResponse
    {
        $req = new DeleteCityActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_city_api_v1_city_list', methods: HttpMethod::GET)]
    #[OA\Parameter(name: 'limit', in: 'query', required: false, description: 'Default 500')]
    #[OA\Parameter(name: 'offset', in: 'query', required: false, description: 'Default 0')]
    #[OA\Parameter(name: 'title', in: 'query', required: false, description: 'City title')]
    #[OA\Parameter(name: 'iata', in: 'query', required: false, description: 'City IATA code')]
    #[OA\Parameter(name: 'countryIso2', in: 'query', required: false, description: 'Couyntry ISO2 code')]
    #[OA\Parameter(name: 'stateTitle', in: 'query', required: false, description: 'State title')]
    #[OA\Response(
        response: 200,
        description: 'List of cities.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: CityResponse::class))
        )
    )]
    public function list(Request $request, GetCitiesActionInterface $action): JsonResponse
    {
        $req = GetCitiesActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->cities);
    }
}
