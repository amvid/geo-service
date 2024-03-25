<?php

declare(strict_types=1);

namespace App\Region\Controller\Api\V1;

use App\Application\Controller\Api\ApiController;
use App\Application\Controller\HttpMethod;
use App\Application\Exception\ValidationException;
use App\Region\Action\Create\CreateRegionActionInterface;
use App\Region\Action\Create\CreateRegionActionRequest;
use App\Region\Action\Delete\DeleteRegionActionInterface;
use App\Region\Action\Delete\DeleteRegionActionRequest;
use App\Region\Action\Get\GetRegionsActionInterface;
use App\Region\Action\Get\GetRegionsActionRequest;
use App\Region\Action\Update\UpdateRegionActionInterface;
use App\Region\Action\Update\UpdateRegionActionRequest;
use App\Region\Controller\Response\RegionResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;

#[OA\Tag(name: 'Regions')]
class RegionController extends ApiController
{
    public const API_ROUTE = '/api/v1/regions';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_region_api_v1_region_create', methods: HttpMethod::POST)]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: CreateRegionActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Region created successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: RegionResponse::class)
        )
    )]
    public function create(Request $request, CreateRegionActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateRegionActionRequest::class);
        return $this->json($action->run($req)->regionResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_region_api_v1_region_delete', methods: HttpMethod::DELETE)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Region uuid'
    )]
    #[OA\Response(
        response: 200,
        description: 'Region deleted successfully.',
    )]
    public function delete(string $id, DeleteRegionActionInterface $action): JsonResponse
    {
        $req = new DeleteRegionActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_region_api_v1_region_list', methods: HttpMethod::GET)]
    #[OA\Parameter(name: 'limit', in: 'query', required: false, description: 'Default 500', content: new OA\JsonContent(type: 'integer'))]
    #[OA\Parameter(name: 'offset', in: 'query', required: false, description: 'Default 0', content: new OA\JsonContent(type: 'integer'))]
    #[OA\Parameter(name: 'title', in: 'query', required: false, description: 'Nationality title', content: new OA\JsonContent(type: 'string'))]
    #[OA\Response(
        response: 200,
        description: 'List of regions.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: RegionResponse::class))
        )
    )]
    public function list(Request $request, GetRegionsActionInterface $action): JsonResponse
    {
        $req = GetRegionsActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->response);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_region_api_v1_region_update', methods: HttpMethod::PUT)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Region uuid'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: UpdateRegionActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Region updated successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: RegionResponse::class)
        )
    )]
    public function update(string $id, Request $request, UpdateRegionActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateRegionActionRequest::class);
        return $this->json($action->run($req, Uuid::fromString($id))->regionResponse);
    }
}
