<?php

declare(strict_types=1);

namespace App\Currency\Controller\Api\V1;

use App\Application\Controller\Api\ApiController;
use App\Application\Controller\HttpMethod;
use App\Application\Exception\ValidationException;
use App\Currency\Action\Create\CreateCurrencyActionInterface;
use App\Currency\Action\Create\CreateCurrencyActionRequest;
use App\Currency\Action\Delete\DeleteCurrencyActionInterface;
use App\Currency\Action\Delete\DeleteCurrencyActionRequest;
use App\Currency\Action\Get\GetCurrenciesActionInterface;
use App\Currency\Action\Get\GetCurrenciesActionRequest;
use App\Currency\Action\Update\UpdateCurrencyActionInterface;
use App\Currency\Action\Update\UpdateCurrencyActionRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends ApiController
{
    private const API_ROUTE = '/api/v1/currencies';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_currency_api_v1_currency_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateCurrencyActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateCurrencyActionRequest::class);
        return $this->json($action->run($req)->currencyResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_currency_api_v1_currency_delete', methods: HttpMethod::DELETE)]
    public function delete(string $id, DeleteCurrencyActionInterface $action): JsonResponse
    {
        $req = new DeleteCurrencyActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_currency_api_v1_currency_list', methods: HttpMethod::GET)]
    public function list(Request $request, GetCurrenciesActionInterface $action): JsonResponse
    {
        $req = GetCurrenciesActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->response);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_currency_api_v1_currency_update', methods: HttpMethod::PUT)]
    public function update(string $id, Request $request, UpdateCurrencyActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateCurrencyActionRequest::class);
        $req->setId($id);

        return $this->json($action->run($req)->currencyResponse);
    }

}