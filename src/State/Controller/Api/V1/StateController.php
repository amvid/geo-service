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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StateController extends ApiController
{
    private const API_ROUTE = '/api/v1/states';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_state_api_v1_state_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateStateActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateStateActionRequest::class);
        return $this->json($action->run($req)->state);
    }

    #[Route(self::API_ROUTE . '/{id}', name: 'app_state_api_v1_state_delete', methods: HttpMethod::DELETE)]
    public function delete(string $id, DeleteStateActionInterface $action): JsonResponse
    {
        $req = new DeleteStateActionRequest($id);
        return $this->json($action->run($req));
    }

    #[Route(self::API_ROUTE, name: 'app_state_api_v1_state_list', methods: HttpMethod::GET)]
    public function list(Request $request): JsonResponse
    {
        return new JsonResponse();
    }

    #[Route(self::API_ROUTE . '/{id}', name: 'app_state_api_v1_state_update', methods: HttpMethod::PUT)]
    public function update(string $id, Request $request): JsonResponse
    {
        return new JsonResponse();
    }
}