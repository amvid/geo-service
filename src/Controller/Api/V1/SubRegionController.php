<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Action\SubRegion\Create\CreateSubRegionActionInterface;
use App\Action\SubRegion\Create\CreateSubRegionActionRequest;
use App\Action\SubRegion\Delete\DeleteSubRegionActionInterface;
use App\Action\SubRegion\Delete\DeleteSubRegionActionRequest;
use App\Action\SubRegion\Get\GetSubRegionsActionInterface;
use App\Action\SubRegion\Get\GetSubRegionsActionRequest;
use App\Action\SubRegion\Update\UpdateSubRegionActionInterface;
use App\Action\SubRegion\Update\UpdateSubRegionActionRequest;
use App\Controller\Api\ApiController;
use App\Controller\HttpMethod;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SubRegionController extends ApiController
{
    private const API_ROUTE = '/api/v1/subregions';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_api_v1_subregion_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateSubRegionActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateSubRegionActionRequest::class);
        return $this->json($action->run($req)->subRegionResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_api_v1_subregion_delete', methods: HttpMethod::DELETE)]
    public function delete(string $id, DeleteSubRegionActionInterface $action): JsonResponse
    {
        $req = new DeleteSubRegionActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_api_v1_subregion_list', methods: HttpMethod::GET)]
    public function list(Request $request, GetSubRegionsActionInterface $action): JsonResponse
    {
        $req = GetSubRegionsActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->response);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_api_v1_subregion_update', methods: HttpMethod::PUT)]
    public function update(string $id, Request $request, UpdateSubRegionActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateSubRegionActionRequest::class);
        $req->setId($id);

        return $this->json($action->run($req)->subRegionResponse);
    }

}