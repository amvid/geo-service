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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Cities')]
class CityController extends ApiController
{
    public const API_ROUTE = '/api/v1/cities';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_city_api_v1_city_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateCityActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateCityActionRequest::class);
        return $this->json($action->run($req)->city);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_city_api_v1_city_update', methods: HttpMethod::PUT)]
    public function update(string $id, Request $request, UpdateCityActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateCityActionRequest::class);
        $req->setId($id);

        return $this->json($action->run($req)->city);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_city_api_v1_city_delete', methods: HttpMethod::DELETE)]
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
    public function list(Request $request, GetCitiesActionInterface $action): JsonResponse
    {
        $req = GetCitiesActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->cities);
    }
}
