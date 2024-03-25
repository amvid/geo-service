<?php

declare(strict_types=1);

namespace App\State\Controller\Api\V1;

use App\Application\Controller\Api\ApiController;
use App\Application\Controller\HttpMethod;
use App\Application\Exception\ValidationException;
use App\State\Action\Create\CreateStateActionInterface;
use App\State\Action\Create\CreateStateActionRequest;
use App\State\Action\Delete\DeleteStateActionInterface;
use App\State\Action\Delete\DeleteStateActionRequest;
use App\State\Action\Get\GetStatesActionInterface;
use App\State\Action\Get\GetStatesActionRequest;
use App\State\Action\Update\UpdateStateActionInterface;
use App\State\Action\Update\UpdateStateActionRequest;
use App\State\Controller\Response\StateResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;

#[OA\Tag(name: 'States')]
class StateController extends ApiController
{
    public const API_ROUTE = '/api/v1/states';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_state_api_v1_state_create', methods: HttpMethod::POST)]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: CreateStateActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Nationality created successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: StateResponse::class)
        )
    )]
    public function create(Request $request, CreateStateActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateStateActionRequest::class);
        return $this->json($action->run($req)->state);
    }

    #[Route(self::API_ROUTE . '/{id}', name: 'app_state_api_v1_state_delete', methods: HttpMethod::DELETE)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'State uuid'
    )]
    #[OA\Response(
        response: 200,
        description: 'State deleted successfully.',
    )]
    public function delete(string $id, DeleteStateActionInterface $action): JsonResponse
    {
        $req = new DeleteStateActionRequest($id);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_state_api_v1_state_list', methods: HttpMethod::GET)]
    #[OA\Parameter(name: 'limit', in: 'query', required: false, description: 'Default 500', content: new OA\JsonContent(type: 'integer'))]
    #[OA\Parameter(name: 'offset', in: 'query', required: false, description: 'Default 0', content: new OA\JsonContent(type: 'integer'))]
    #[OA\Parameter(name: 'title', in: 'query', required: false, description: 'State title', content: new OA\JsonContent(type: 'string'))]
    #[OA\Response(
        response: 200,
        description: 'List of states.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: StateResponse::class))
        )
    )]
    public function list(Request $request, GetStatesActionInterface $action): JsonResponse
    {
        $req = GetStatesActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->response);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_state_api_v1_state_update', methods: HttpMethod::PUT)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'State uuid'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: UpdateStateActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Nationality updated successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: StateResponse::class)
        )
    )]
    public function update(string $id, Request $request, UpdateStateActionInterface $action): JsonResponse
    {
        /** @var UpdateStateActionRequest $req */
        $req = $this->handleRequest($request, UpdateStateActionRequest::class);
        return $this->json($action->run($req, Uuid::fromString($id))->state);
    }
}
