<?php

declare(strict_types=1);

namespace App\Country\Controller\Api\V1;

use App\Application\Controller\Api\ApiController;
use App\Application\Controller\HttpMethod;
use App\Application\Exception\ValidationException;
use App\Country\Action\Create\CreateCountryActionInterface;
use App\Country\Action\Create\CreateCountryActionRequest;
use App\Country\Action\Delete\DeleteCountryActionInterface;
use App\Country\Action\Delete\DeleteCountryActionRequest;
use App\Country\Action\Get\GetCountriesActionInterface;
use App\Country\Action\Get\GetCountriesActionRequest;
use App\Country\Action\GetPhoneCodes\GetPhoneCodesActionInterface;
use App\Country\Action\GetPhoneCodes\GetPhoneCodesActionRequest;
use App\Country\Action\Update\UpdateCountryActionInterface;
use App\Country\Action\Update\UpdateCountryActionRequest;
use JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends ApiController
{
    public const API_ROUTE = '/api/v1/countries';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_country_api_v1_country_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateCountryActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateCountryActionRequest::class);
        return $this->json($action->run($req)->countryResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_country_api_v1_country_delete', methods: HttpMethod::DELETE)]
    public function delete(string $id, DeleteCountryActionInterface $action): JsonResponse
    {
        $req = new DeleteCountryActionRequest($id);
        $this->validateRequest($req);
        return $this->json($action->run($req));
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_country_api_v1_country_list', methods: HttpMethod::GET)]
    public function list(Request $request, GetCountriesActionInterface $action): JsonResponse
    {
        $req = GetCountriesActionRequest::fromArray($request->query->all());
        $this->validateRequest($req);

        return $this->json($action->run($req)->response);
    }

    /**
     * @throws ValidationException|JsonException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_country_api_v1_country_update', methods: HttpMethod::PUT)]
    public function update(string $id, Request $request, UpdateCountryActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateCountryActionRequest::class);
        $req->setId($id);

        return $this->json($action->run($req)->countryResponse);
    }

    #[Route(self::API_ROUTE . '/phone-codes', name: 'app_country_api_v1_country_phone_codes', methods: HttpMethod::GET)]
    public function getPhoneCodes(Request $request, GetPhoneCodesActionInterface $action): JsonResponse
    {
        $req = GetPhoneCodesActionRequest::fromArray($request->query->all());
        return $this->json($action->run($req)->response);
    }
}
