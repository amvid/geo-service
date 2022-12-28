<?php

declare(strict_types=1);

namespace App\Region\Controller\Api\V1;

use App\Controller\Api\ApiController;
use App\Controller\HttpMethod;
use App\Exception\ValidationException;
use App\Region\Action\Create\CreateRegionActionInterface;
use App\Region\Action\Create\CreateRegionActionRequest;
use App\Region\Action\Delete\DeleteRegionActionInterface;
use App\Region\Action\Delete\DeleteRegionActionRequest;
use App\Region\Action\Get\GetRegionsActionInterface;
use App\Region\Action\Get\GetRegionsActionRequest;
use App\Region\Action\Update\UpdateRegionActionInterface;
use App\Region\Action\Update\UpdateRegionActionRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegionController extends ApiController
{
    private const API_ROUTE = '/api/v1/regions';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_region_api_v1_region_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateRegionActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateRegionActionRequest::class);
        return $this->json($action->run($req)->regionResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_region_api_v1_region_delete', methods: HttpMethod::DELETE)]
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
    public function update(string $id, Request $request, UpdateRegionActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateRegionActionRequest::class);
        $req->setId($id);

        return $this->json($action->run($req)->regionResponse);
    }

}