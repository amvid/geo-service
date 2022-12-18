<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Action\Region\Create\CreateRegionActionInterface;
use App\Action\Region\Create\CreateRegionActionRequest;
use App\Action\Region\Delete\DeleteRegionActionInterface;
use App\Action\Region\Delete\DeleteRegionActionRequest;
use App\Action\Region\Get\GetRegionsAction;
use App\Action\Region\Get\GetRegionsActionRequest;
use App\Controller\Api\ApiController;
use App\Controller\HttpMethod;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegionController extends ApiController
{
    private const API_ROUTE = '/api/v1/regions';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_api_v1_region_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateRegionActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateRegionActionRequest::class);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{title}', name: 'app_api_v1_region_delete', methods: HttpMethod::DELETE)]
    public function delete(string $title, DeleteRegionActionInterface $action): JsonResponse
    {
        $req = new DeleteRegionActionRequest($title);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_api_v1_region_list', methods: HttpMethod::GET)]
    public function list(Request $request, GetRegionsAction $action): JsonResponse
    {
        $req = GetRegionsActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->regions);
    }

}