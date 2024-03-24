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
use App\Country\Controller\Response\CountryResponse;
use App\Country\Controller\Response\PhoneCodeResponse;
use JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;

#[OA\Tag(name: 'Countries')]
class CountryController extends ApiController
{
    public const API_ROUTE = '/api/v1/countries';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_country_api_v1_country_create', methods: HttpMethod::POST)]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: CreateCountryActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Country created successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: CountryResponse::class)
        )
    )]
    public function create(Request $request, CreateCountryActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateCountryActionRequest::class);
        return $this->json($action->run($req)->countryResponse);
    }

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE . '/{id}', name: 'app_country_api_v1_country_delete', methods: HttpMethod::DELETE)]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Country uuid'
    )]
    #[OA\Response(
        response: 200,
        description: 'Country deleted successfully.',
    )]
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
    #[OA\Parameter(name: 'limit', in: 'query', required: false, description: 'Default 500')]
    #[OA\Parameter(name: 'offset', in: 'query', required: false, description: 'Default 0')]
    #[OA\Parameter(name: 'title', in: 'query', required: false, description: 'Country title')]
    #[OA\Parameter(name: 'id', in: 'query', required: false, description: 'Country uuid')]
    #[OA\Parameter(name: 'iso2', in: 'query', required: false, description: 'Country ISO2 code')]
    #[OA\Parameter(name: 'iso3', in: 'query', required: false, description: 'Country ISO3 code')]
    #[OA\Parameter(name: 'nativeTitle', in: 'query', required: false, description: 'Country native title')]
    #[OA\Parameter(name: 'numericCode', in: 'query', required: false, description: 'Country numeric code')]
    #[OA\Parameter(name: 'tld', in: 'query', required: false, description: 'Country top level domain')]
    #[OA\Parameter(name: 'subRegion', in: 'query', required: false, description: 'SubRegion title')]
    #[OA\Parameter(name: 'currencyCode', in: 'query', required: false, description: 'Currency code')]
    #[OA\Response(
        response: 200,
        description: 'Countries list',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: CountryResponse::class)
        )
    )]
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
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Country uuid'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            ref: new Model(type: UpdateCountryActionRequest::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Country updated successfully.',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: CountryResponse::class)
        )
    )]
    public function update(string $id, Request $request, UpdateCountryActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, UpdateCountryActionRequest::class);
        return $this->json($action->run($req, Uuid::fromString($id))->countryResponse);
    }

    #[Route(self::API_ROUTE . '/phone-codes', name: 'app_country_api_v1_country_phone_codes', methods: HttpMethod::GET)]
    #[OA\Parameter(name: 'limit', in: 'query', required: false, description: 'Default 500')]
    #[OA\Parameter(name: 'offset', in: 'query', required: false, description: 'Default 0')]
    #[OA\Parameter(name: 'title', in: 'query', required: false, description: 'Country title')]
    #[OA\Parameter(name: 'phoneCode', in: 'query', required: false, description: 'Phone code')]
    #[OA\Response(
        response: 200,
        description: 'Phone codes list',
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: PhoneCodeResponse::class)
        )
    )]
    public function getPhoneCodes(Request $request, GetPhoneCodesActionInterface $action): JsonResponse
    {
        $req = GetPhoneCodesActionRequest::fromArray($request->query->all());
        return $this->json($action->run($req)->response);
    }
}
