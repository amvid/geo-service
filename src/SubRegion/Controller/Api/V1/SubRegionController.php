<?php

declare(strict_types=1);

namespace App\SubRegion\Controller\Api\V1;

use App\Application\Controller\Api\ApiController;
use App\Application\Controller\HttpMethod;
use App\Application\Exception\ValidationException;
use App\SubRegion\Action\Create\CreateSubRegionActionInterface;
use App\SubRegion\Action\Create\CreateSubRegionActionRequest;
use App\SubRegion\Action\Delete\DeleteSubRegionActionInterface;
use App\SubRegion\Action\Delete\DeleteSubRegionActionRequest;
use App\SubRegion\Action\Get\GetSubRegionsActionInterface;
use App\SubRegion\Action\Get\GetSubRegionsActionRequest;
use App\SubRegion\Action\Update\UpdateSubRegionActionInterface;
use App\SubRegion\Action\Update\UpdateSubRegionActionRequest;
use App\SubRegion\Controller\Response\SubRegionResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;

#[OA\Tag(name: 'SubRegions')]
class SubRegionController extends ApiController
{
    public const API_ROUTE = '/api/v1/subregions';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_subregion_api_v1_subregion_create', methods: HttpMethod::POST)]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: CreateSubRegionActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Nationality created successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: SubRegionResponse::class)
        )
    )]
    public function create(Request $request, CreateSubRegionActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateSubRegionActionRequest::class);
        return $this->json($action->run($req)->subRegionResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_subregion_api_v1_subregion_delete', methods: HttpMethod::DELETE)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'SubRegion uuid'
    )]
    #[OA\Response(
        response: 200,
        description: 'SubRegion deleted successfully.',
    )]
    public function delete(string $id, DeleteSubRegionActionInterface $action): JsonResponse
    {
        $req = new DeleteSubRegionActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_subregion_api_v1_subregion_list', methods: HttpMethod::GET)]
    #[OA\Parameter(name: 'limit', in: 'query', required: false, description: 'Default 500')]
    #[OA\Parameter(name: 'offset', in: 'query', required: false, description: 'Default 0')]
    #[OA\Parameter(name: 'title', in: 'query', required: false, description: 'SubRegion title')]
    #[OA\Response(
        response: 200,
        description: 'List of subregions.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: SubRegionResponse::class))
        )
    )]
    public function list(Request $request, GetSubRegionsActionInterface $action): JsonResponse
    {
        $req = GetSubRegionsActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->response);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_subregion_api_v1_subregion_update', methods: HttpMethod::PUT)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'SubRegion uuid'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: UpdateSubRegionActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'SubRegion updated successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: SubRegionResponse::class)
        )
    )]
    public function update(string $id, Request $request, UpdateSubRegionActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateSubRegionActionRequest::class);
        return $this->json($action->run($req, Uuid::fromString($id))->subRegionResponse);
    }
}
