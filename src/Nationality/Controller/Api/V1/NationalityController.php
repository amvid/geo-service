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
use App\Nationality\Controller\Response\NationalityResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;

#[OA\Tag(name: 'Nationalities')]
class NationalityController extends ApiController
{
    public const API_ROUTE = '/api/v1/nationalities';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_nationalities_api_v1_nationality_create', methods: HttpMethod::POST)]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: CreateNationalityActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Nationality created successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: NationalityResponse::class)
        )
    )]
    public function create(Request $request, CreateNationalityActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateNationalityActionRequest::class);
        return $this->json($action->run($req)->nationalityResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_nationalities_api_v1_nationality_delete', methods: HttpMethod::DELETE)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Nationality uuid'
    )]
    #[OA\Response(
        response: 200,
        description: 'Nationality deleted successfully.',
    )]
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
    #[OA\Parameter(name: 'limit', in: 'query', required: false, description: 'Default 500', content: new OA\JsonContent(type: 'integer'))]
    #[OA\Parameter(name: 'offset', in: 'query', required: false, description: 'Default 0', content: new OA\JsonContent(type: 'integer'))]
    #[OA\Parameter(name: 'title', in: 'query', required: false, description: 'Nationality title', content: new OA\JsonContent(type: 'string'))]
    #[OA\Response(
        response: 200,
        description: 'List of nationalities.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: NationalityResponse::class))
        )
    )]
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
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Nationality uuid'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: UpdateNationalityActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Nationality updated successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: NationalityResponse::class)
        )
    )]
    public function update(string $id, Request $request, UpdateNationalityActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateNationalityActionRequest::class);
        return $this->json($action->run($req, Uuid::fromString($id))->nationalityResponse);
    }
}
