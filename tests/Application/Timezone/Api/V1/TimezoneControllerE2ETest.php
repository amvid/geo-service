<?php

declare(strict_types=1);

namespace App\Tests\Application\Timezone\Api\V1;

use App\Application\Controller\HttpMethod;
use App\Tests\Unit\Timezone\TimezoneDummy;
use App\Timezone\Controller\Api\V1\TimezoneController;
use App\Timezone\Entity\Timezone;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use Exception;
use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TimezoneControllerE2ETest extends WebTestCase
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
            'title' => 'America/California',
            'code' => 'America/California',
            'utc' => '+08:00',
        ];

        $this->client->request(
            HttpMethod::POST,
            TimezoneController::API_ROUTE,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        $response = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertEquals($content['title'], $response['title']);
    }

    public function testCreateActionErrorBadRequest(): void
    {
        $content = '{
            "title": "America/California",
            "code": "America/California"
        }';

        $this->client->request(HttpMethod::POST, TimezoneController::API_ROUTE, content: $content);

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        self::assertTrue(str_contains($this->client->getResponse()->getContent(), 'This value should not be blank'));
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testUpdateActionSuccess(): void
    {
        /** @var Timezone $timezone */
        $timezone = self::getContainer()->get(TimezoneRepositoryInterface::class)->findByCode(TimezoneDummy::CODE);

        $content = ['title' => 'Updated Title'];

        $this->client->request(
            HttpMethod::PUT,
            TimezoneController::API_ROUTE . '/' . $timezone->getId()->toString(),
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
        $id = TimezoneDummy::ID;
        $this->client->request(
            HttpMethod::PUT,
            TimezoneController::API_ROUTE . '/' . $id,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertEquals(
            "{\"error\":\"Timezone '$id' not found.\"}",
            $this->client->getResponse()->getContent()
        );
    }

    /**
     * @throws Exception
     */
    public function testDeleteActionSuccess(): void
    {
        $this->client->request(HttpMethod::DELETE, TimezoneController::API_ROUTE . '/' . TimezoneDummy::ID);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
