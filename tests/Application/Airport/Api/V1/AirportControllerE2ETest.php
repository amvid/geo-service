<?php

declare(strict_types=1);

namespace App\Tests\Application\Airport\Api\V1;

use App\Airport\Controller\Api\V1\AirportController;
use App\Airport\Entity\Airport;
use App\Airport\Repository\AirportRepositoryInterface;
use App\Application\Controller\HttpMethod;
use App\Tests\Unit\Airport\AirportDummy;
use App\Tests\Unit\Country\CountryDummy;
use Exception;
use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AirportControllerE2ETest extends WebTestCase
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
            'countryIso2' => 'US',
            'title' => 'Test Airport',
            'cityTitle' => 'California',
            'timezone' => 'America/Nome',
            'iata' => 'TST',
            'icao' => 'TEST',
            'longitude' => 11,
            'latitude' => 22,
            'altitude' => 10,
            'rank' => 0.11,
        ];

        $this->client->request(
            HttpMethod::POST,
            AirportController::API_ROUTE,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        $response = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertEquals($content['title'], $response['title']);
        self::assertEquals($content['rank'], $response['rank']);
    }

    public function testQueryActionSuccess(): void
    {
        $this->client->request(HttpMethod::GET, AirportController::API_ROUTE . '/AAA');

        $response = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertEquals(1, count($response));
        self::assertEquals(AirportDummy::TITLE, $response[0]['title']);
        self::assertEquals(AirportDummy::IATA, $response[0]['iata']);
        self::assertEquals(CountryDummy::TITLE, $response[0]['country']);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateActionErrorBadRequest(): void
    {
        $content = '{
            "cityTitle": "California",
            "timezone": "America/Nome",
            "iata": "TST",
            "icao": "TEST",
            "longitude": 11,
            "latitude": 22
        }';

        $this->client->request(HttpMethod::POST, AirportController::API_ROUTE, content: $content);

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        self::assertTrue(str_contains($this->client->getResponse()->getContent(), 'This value should not be blank'));
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testUpdateActionSuccess(): void
    {
        /** @var Airport $airport */
        $airport = self::getContainer()->get(AirportRepositoryInterface::class)->findByTitle(AirportDummy::TITLE)[0];

        $content = ['title' => 'Updated Title'];

        $this->client->request(
            HttpMethod::PUT,
            AirportController::API_ROUTE . '/' . $airport->getId()->toString(),
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
    public function testUpdateActionAirportNotFound(): void
    {
        $content = ['title' => 'Updated Title'];

        $this->client->request(
            HttpMethod::PUT,
            AirportController::API_ROUTE . '/' . AirportDummy::ID,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertEquals(
            "{\"error\":\"Airport '1f21557e-f115-4d21-bab1-f401ddc78a62' not found.\"}",
            $this->client->getResponse()->getContent()
        );
    }

    /**
     * @throws Exception
     */
    public function testDeleteActionSuccess(): void
    {
        $this->client->request(HttpMethod::DELETE, AirportController::API_ROUTE . '/' . AirportDummy::ID);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
