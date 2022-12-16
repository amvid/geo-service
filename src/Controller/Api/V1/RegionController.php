<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Action\Region\Create\CreateRegionActionInterface;
use App\Action\Region\Create\CreateRegionActionRequest;
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

}