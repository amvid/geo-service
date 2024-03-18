<?php

declare(strict_types=1);

namespace App\Nationality\Controller\Api\V1;

use App\Application\Controller\Api\ApiController;
use App\Application\Controller\HttpMethod;
use App\Application\Exception\ValidationException;
use App\Nationality\Action\Create\CreateNationalityActionInterface;
use App\Nationality\Action\Create\CreateNationalityActionRequest;
use App\Nationality\Action\Delete\DeleteNationalityActionInterface;
use App\Nationality\Action\Delete\DeleteNationalityActionRequest;
use App\Nationality\Action\Get\GetNationalitiesActionInterface;
use App\Nationality\Action\Get\GetNationalitiesActionRequest;
use App\Nationality\Action\Update\UpdateNationalityActionInterface;
use App\Nationality\Action\Update\UpdateNationalityActionRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NationalityController extends ApiController
{
    public const API_ROUTE = '/api/v1/nationalities';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_nationalities_api_v1_nationality_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateNationalityActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateNationalityActionRequest::class);
        return $this->json($action->run($req)->nationalityResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_nationalities_api_v1_nationality_delete', methods: HttpMethod::DELETE)]
    public function delete(string $id, DeleteNationalityActionInterface $action): JsonResponse
    {
        $req = new DeleteNationalityActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_nationalities_api_v1_nationality_list', methods: HttpMethod::GET)]
    public function list(Request $request, GetNationalitiesActionInterface $action): JsonResponse
    {
        $req = GetNationalitiesActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->response);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_nationalities_api_v1_nationality_update', methods: HttpMethod::PUT)]
    public function update(string $id, Request $request, UpdateNationalityActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateNationalityActionRequest::class);
        $req->setId($id);

        return $this->json($action->run($req)->nationalityResponse);
    }
}
