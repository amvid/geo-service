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
use App\Timezone\Controller\Response\TimezoneResponse;
use App\Timezone\Exception\TimezoneNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;

#[OA\Tag(name: 'Timezones')]
class TimezoneController extends ApiController
{
    public const API_ROUTE = '/api/v1/timezones';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_timezone_api_v1_timezone_create', methods: HttpMethod::POST)]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: CreateTimezoneActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Nationality created successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: TimezoneResponse::class)
        )
    )]
    public function create(Request $request, CreateTimezoneActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateTimezoneActionRequest::class);
        return $this->json($action->run($req)->timezoneResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_timezone_api_v1_timezone_delete', methods: HttpMethod::DELETE)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Timezone uuid'
    )]
    #[OA\Response(
        response: 200,
        description: 'Timezone deleted successfully.',
    )]
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
    #[OA\Parameter(name: 'limit', in: 'query', required: false, description: 'Default 500', content: new OA\JsonContent(type: 'integer'))]
    #[OA\Parameter(name: 'offset', in: 'query', required: false, description: 'Default 0', content: new OA\JsonContent(type: 'integer'))]
    #[OA\Parameter(name: 'title', in: 'query', required: false, description: 'Timezone title', content: new OA\JsonContent(type: 'string'))]
    #[OA\Parameter(name: 'code', in: 'query', required: false, description: 'Timezone code', content: new OA\JsonContent(type: 'string'))]
    #[OA\Parameter(name: 'utc', in: 'query', required: false, description: 'Timezone UTC', content: new OA\JsonContent(type: 'string'))]
    #[OA\Response(
        response: 200,
        description: 'List of timezones.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: TimezoneResponse::class))
        )
    )]
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
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Timezone uuid'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: UpdateTimezoneActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Timezone updated successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: TimezoneResponse::class)
        )
    )]
    public function update(string $id, Request $request, UpdateTimezoneActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateTimezoneActionRequest::class);
        return $this->json($action->run($req, Uuid::fromString($id))->timezoneResponse);
    }
}
