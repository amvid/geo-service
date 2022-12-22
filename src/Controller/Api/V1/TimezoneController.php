<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Action\Timezone\Create\CreateTimezoneActionInterface;
use App\Action\Timezone\Create\CreateTimezoneActionRequest;
use App\Action\Timezone\Delete\DeleteTimezoneActionInterface;
use App\Action\Timezone\Delete\DeleteTimezoneActionRequest;
use App\Action\Timezone\Get\GetTimezonesActionInterface;
use App\Action\Timezone\Get\GetTimezonesActionRequest;
use App\Action\Timezone\Update\UpdateTimezoneActionInterface;
use App\Action\Timezone\Update\UpdateTimezoneActionRequest;
use App\Controller\Api\ApiController;
use App\Controller\HttpMethod;
use App\Exception\TimezoneNotFoundException;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TimezoneController extends ApiController
{
    private const API_ROUTE = '/api/v1/timezones';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_api_v1_timezone_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateTimezoneActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateTimezoneActionRequest::class);
        return $this->json($action->run($req)->timezoneResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_api_v1_timezone_delete', methods: HttpMethod::DELETE)]
    public function delete(string $id, DeleteTimezoneActionInterface $action): JsonResponse
    {
        $req = new DeleteTimezoneActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_api_v1_timezone_list', methods: HttpMethod::GET)]
    public function list(Request $request, GetTimezonesActionInterface $action): JsonResponse
    {
        $req = GetTimezonesActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->response);
    }

    /**
     * @throws ValidationException|TimezoneNotFoundException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_api_v1_timezone_update', methods: HttpMethod::PUT)]
    public function update(string $id, Request $request, UpdateTimezoneActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateTimezoneActionRequest::class);
        $req->setId($id);

        return $this->json($action->run($req)->timezoneResponse);
    }

}