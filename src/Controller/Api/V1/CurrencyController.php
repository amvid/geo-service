<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Action\Currency\Create\CreateCurrencyActionInterface;
use App\Action\Currency\Create\CreateCurrencyActionRequest;
use App\Action\Currency\Delete\DeleteCurrencyActionInterface;
use App\Action\Currency\Delete\DeleteCurrencyActionRequest;
use App\Action\Currency\Get\GetCurrenciesActionInterface;
use App\Action\Currency\Get\GetCurrenciesActionRequest;
use App\Action\Currency\Update\UpdateCurrencyActionInterface;
use App\Action\Currency\Update\UpdateCurrencyActionRequest;
use App\Controller\Api\ApiController;
use App\Controller\HttpMethod;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends ApiController
{
    private const API_ROUTE = '/api/v1/currencies';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_api_v1_currency_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateCurrencyActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateCurrencyActionRequest::class);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_api_v1_currency_delete', methods: HttpMethod::DELETE)]
    public function delete(string $id, DeleteCurrencyActionInterface $action): JsonResponse
    {
        $req = new DeleteCurrencyActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_api_v1_currency_list', methods: HttpMethod::GET)]
    public function list(Request $request, GetCurrenciesActionInterface $action): JsonResponse
    {
        $req = GetCurrenciesActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->currencies);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_api_v1_currency_update', methods: HttpMethod::PUT)]
    public function update(string $id, Request $request, UpdateCurrencyActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateCurrencyActionRequest::class);
        $req->setId($id);

        return $this->json($action->run($req));
    }

}