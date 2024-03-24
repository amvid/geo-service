<?php

declare(strict_types=1);

namespace App\Timezone\Controller\Api\V1;

use App\Application\Controller\Api\ApiController;
use App\Application\Controller\HttpMethod;
use App\Application\Exception\ValidationException;
use App\Timezone\Action\Create\CreateTimezoneActionInterface;
use App\Timezone\Action\Create\CreateTimezoneActionRequest;
use App\Timezone\Action\Delete\DeleteTimezoneActionInterface;
use App\Timezone\Action\Delete\DeleteTimezoneActionRequest;
use App\Timezone\Action\Get\GetTimezonesActionInterface;
use App\Timezone\Action\Get\GetTimezonesActionRequest;
use App\Timezone\Action\Update\UpdateTimezoneActionInterface;
use App\Timezone\Action\Update\UpdateTimezoneActionRequest;
use App\Timezone\Exception\TimezoneNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Timezones')]
class TimezoneController extends ApiController
{
    public const API_ROUTE = '/api/v1/timezones';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_timezone_api_v1_timezone_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateTimezoneActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateTimezoneActionRequest::class);
        return $this->json($action->run($req)->timezoneResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_timezone_api_v1_timezone_delete', methods: HttpMethod::DELETE)]
    public function delete(string $id, DeleteTimezoneActionInterface $action): JsonResponse
    {
        $req = new DeleteTimezoneActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_timezone_api_v1_timezone_list', methods: HttpMethod::GET)]
    public function list(Request $request, GetTimezonesActionInterface $action): JsonResponse
    {
        $req = GetTimezonesActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->response);
    }

    /**
     * @throws ValidationException|TimezoneNotFoundException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_timezone_api_v1_timezone_update', methods: HttpMethod::PUT)]
    public function update(string $id, Request $request, UpdateTimezoneActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateTimezoneActionRequest::class);
        $req->setId($id);

        return $this->json($action->run($req)->timezoneResponse);
    }
}
