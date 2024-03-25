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
use App\Currency\Controller\Response\CurrencyResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;

#[OA\Tag(name: 'Currencies')]
class CurrencyController extends ApiController
{
    public const API_ROUTE = '/api/v1/currencies';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_currency_api_v1_currency_create', methods: HttpMethod::POST)]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: CreateCurrencyActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Currency created successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: CurrencyResponse::class)
        )
    )]
    public function create(Request $request, CreateCurrencyActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateCurrencyActionRequest::class);
        return $this->json($action->run($req)->currencyResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_currency_api_v1_currency_delete', methods: HttpMethod::DELETE)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Currency uuid'
    )]
    #[OA\Response(
        response: 200,
        description: 'Currency deleted successfully.',
    )]
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
    #[OA\Parameter(name: 'limit', in: 'query', required: false, description: 'Default 500', content: new OA\JsonContent(type: 'integer'))]
    #[OA\Parameter(name: 'offset', in: 'query', required: false, description: 'Default 0', content: new OA\JsonContent(type: 'integer'))]
    #[OA\Parameter(name: 'name', in: 'query', required: false, description: 'Currency name', content: new OA\JsonContent(type: 'string'))]
    #[OA\Parameter(name: 'code', in: 'query', required: false, description: 'Currency code', content: new OA\JsonContent(type: 'string'))]
    #[OA\Parameter(name: 'symbol', in: 'query', required: false, description: 'Currency symbol', content: new OA\JsonContent(type: 'string'))]
    #[OA\Response(
        response: 200,
        description: 'List of currencies.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: CurrencyResponse::class))
        )
    )]
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
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Currency uuid'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: UpdateCurrencyActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Currency updated successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: CurrencyResponse::class)
        )
    )]
    public function update(string $id, Request $request, UpdateCurrencyActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateCurrencyActionRequest::class);
        return $this->json($action->run($req, Uuid::fromString($id))->currencyResponse);
    }
}
