<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Action\Timezone\Create\CreateTimezoneAction;
use App\Action\Timezone\Create\CreateTimezoneActionRequest;
use App\Controller\Api\ApiController;
use App\Controller\HttpMethod;
use App\Exception\TimezoneAlreadyExistsException;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TimezoneController extends ApiController
{
    private const API_ROUTE = '/api/v1/timezones';

    /**
     * @throws ValidationException|TimezoneAlreadyExistsException
     */
    #[Route(self::API_ROUTE, name: 'app_api_v1_timezone_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateTimezoneAction $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateTimezoneActionRequest::class);
        return $this->json($action->run($req));
    }

}