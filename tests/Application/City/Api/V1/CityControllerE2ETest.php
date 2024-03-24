<?php

declare(strict_types=1);

namespace App\Tests\Application\City\Api\V1;

use App\Application\Controller\HttpMethod;
use App\City\Controller\Api\V1\CityController;
use App\City\Entity\City;
use App\City\Repository\CityRepositoryInterface;
use App\Tests\Unit\City\CityDummy;
use App\Tests\Unit\Country\CountryDummy;
use App\Tests\Unit\State\StateDummy;
use Exception;
use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CityControllerE2ETest extends WebTestCase
{
    private KernelBrowser $client;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = static::createClient(server: ['HTTP_AUTHORIZATION' => 'qwerty']);
    }

    /**
     * @throws JsonException
     */
    public function testCreateActionSuccess(): void
    {
        $content = [
            'title' => 'Test City',
            'iata' => 'TST',
            'countryIso2' => CountryDummy::ISO2,
            'stateTitle' => StateDummy::TITLE,
            'longitude' => 11,
            'latitude' => 22,
            'altitude' => 10,
        ];

        $this->client->request(
            HttpMethod::POST,
            CityController::API_ROUTE,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        $response = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertEquals($content['title'], $response['title']);
    }

    /**
     * @throws JsonException
     */
    public function testCreateActionErrorBadRequest(): void
    {
        $content = [
            'countryIso2' => CountryDummy::ISO2,
            'stateTitle' => StateDummy::TITLE,
            'longitude' => 11,
            'latitude' => 22,
            'altitude' => 10,
        ];

        $this->client->request(
            HttpMethod::POST,
            CityController::API_ROUTE,
            content: json_encode($content, JSON_THROW_ON_ERROR | true)
        );

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        self::assertTrue(str_contains($this->client->getResponse()->getContent(), 'This value should not be blank'));
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testUpdateActionSuccess(): void
    {
        /** @var City $city */
        $city = self::getContainer()->get(CityRepositoryInterface::class)->findByTitle(CityDummy::TITLE)[0];

        $content = ['title' => 'Updated Title', 'countryIso2' => CountryDummy::ISO2];

        $this->client->request(
            HttpMethod::PUT,
            CityController::API_ROUTE . '/' . $city->getId()->toString(),
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        $response = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertEquals($content['title'], $response['title']);
    }

    /**
     * @throws JsonException
     */
    public function testUpdateActionCityNotFound(): void
    {
        $content = ['title' => 'Updated Title', 'countryIso2' => CountryDummy::ISO2];
        $id = CityDummy::ID;
        $this->client->request(
            HttpMethod::PUT,
            CityController::API_ROUTE . '/' . $id,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertEquals(
            "{\"error\":\"City '$id' not found.\"}",
            $this->client->getResponse()->getContent()
        );
    }

    /**
     * @throws Exception
     */
    public function testDeleteActionSuccess(): void
    {
        $this->client->request(HttpMethod::DELETE, CityController::API_ROUTE . '/' . CityDummy::ID);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
