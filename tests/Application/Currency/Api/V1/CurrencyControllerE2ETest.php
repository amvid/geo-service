<?php

declare(strict_types=1);

namespace App\Tests\Application\Currency\Api\V1;

use App\Application\Controller\HttpMethod;
use App\Currency\Controller\Api\V1\CurrencyController;
use App\Currency\Entity\Currency;
use App\Currency\Repository\CurrencyRepositoryInterface;
use App\Tests\Unit\Currency\CurrencyDummy;
use Exception;
use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CurrencyControllerE2ETest extends WebTestCase
{
    private KernelBrowser $client;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @throws JsonException
     */
    public function testCreateActionSuccess(): void
    {
        $content = [
            'name' => 'Norwegian Krone',
            'code' => 'NOK',
            'symbol' => 'kr',
        ];

        $this->client->request(
            HttpMethod::POST,
            CurrencyController::API_ROUTE,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        $response = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertEquals($content['name'], $response['name']);
    }

    public function testCreateActionErrorBadRequest(): void
    {
        $content = '{
            "name": "Norwegian Krone",
            "symbol": "kr"
        }';

        $this->client->request(HttpMethod::POST, CurrencyController::API_ROUTE, content: $content);

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        self::assertTrue(str_contains($this->client->getResponse()->getContent(), 'This value should not be blank'));
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testUpdateActionSuccess(): void
    {
        /** @var Currency $currency */
        $currency = self::getContainer()->get(CurrencyRepositoryInterface::class)->findByCode(CurrencyDummy::CODE);

        $content = ['name' => 'Updated Name'];

        $this->client->request(
            HttpMethod::PUT,
            CurrencyController::API_ROUTE . '/' . $currency->getId()->toString(),
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        $response = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertEquals($content['name'], $response['name']);
    }

    /**
     * @throws JsonException
     */
    public function testUpdateActionAirportNotFound(): void
    {
        $content = ['name' => 'Updated Name'];
        $id = CurrencyDummy::ID;
        $this->client->request(
            HttpMethod::PUT,
            CurrencyController::API_ROUTE . '/' . $id,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertEquals(
            "{\"error\":\"Currency '$id' not found.\"}",
            $this->client->getResponse()->getContent()
        );
    }

    /**
     * @throws Exception
     */
    public function testDeleteActionSuccess(): void
    {
        $this->client->request(HttpMethod::DELETE, CurrencyController::API_ROUTE . '/' . CurrencyDummy::ID);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
