<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Action\Country\Create\CreateCountryActionInterface;
use App\Action\Country\Create\CreateCountryActionRequest;
use App\Action\Country\Delete\DeleteCountryActionInterface;
use App\Action\Country\Delete\DeleteCountryActionRequest;
use App\Action\Country\Update\UpdateCountryActionInterface;
use App\Action\Country\Update\UpdateCountryActionRequest;
use App\Controller\Api\ApiController;
use App\Controller\HttpMethod;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends ApiController
{
    private const API_ROUTE = '/api/v1/countries';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_api_v1_country_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateCountryActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateCountryActionRequest::class);
        return $this->json($action->run($req)->countryResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_api_v1_country_delete', methods: HttpMethod::DELETE)]
    public function delete(string $id, DeleteCountryActionInterface $action): JsonResponse
    {
        $req = new DeleteCountryActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

//    /**
//     * @throws ValidationException
//     */
//    #[Route(self::API_ROUTE, name: 'app_api_v1_country_list', methods: HttpMethod::GET)]
//    public function list(Request $request, GetCurrenciesActionInterface $action): JsonResponse
//    {
//        $req = GetCurrenciesActionRequest::fromArray($request->query->all());
//        $this->validateRequest($req);
//
//        return $this->json($action->run($req)->response);
//    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_api_v1_country_update', methods: HttpMethod::PUT)]
    public function update(string $id, Request $request, UpdateCountryActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateCountryActionRequest::class);
        $req->setId($id);

        return $this->json($action->run($req)->countryResponse);
    }

}