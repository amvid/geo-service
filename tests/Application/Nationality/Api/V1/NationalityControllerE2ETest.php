<?php

declare(strict_types=1);

namespace App\Tests\Application\Nationality\Api\V1;

use App\Application\Controller\HttpMethod;
use App\Nationality\Controller\Api\V1\NationalityController;
use App\Nationality\Entity\Nationality;
use App\Nationality\Repository\NationalityRepositoryInterface;
use App\Tests\Unit\Nationality\NationalityDummy;
use Exception;
use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class NationalityControllerE2ETest extends WebTestCase
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
            'title' => 'AmericanTest',
        ];

        $this->client->request(
            HttpMethod::POST,
            NationalityController::API_ROUTE,
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
            "wrongParam": "American"
        }';

        $this->client->request(HttpMethod::POST, NationalityController::API_ROUTE, content: $content);

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        self::assertTrue(str_contains($this->client->getResponse()->getContent(), 'This value should not be blank'));
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testUpdateActionSuccess(): void
    {
        /** @var Nationality $nationality */
        $nationality = self::getContainer()
            ->get(NationalityRepositoryInterface::class)
            ->findByTitle(NationalityDummy::TITLE);

        $content = ['title' => 'Norwegian'];

        $this->client->request(
            HttpMethod::PUT,
            NationalityController::API_ROUTE . '/' . $nationality->getId()->toString(),
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
    public function testUpdateActionNationalityNotFound(): void
    {
        $content = ['title' => 'Norwegian'];
        $id = NationalityDummy::ID;
        $this->client->request(
            HttpMethod::PUT,
            NationalityController::API_ROUTE . '/' . $id,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertEquals(
            "{\"error\":\"Nationality '$id' not found.\"}",
            $this->client->getResponse()->getContent()
        );
    }

    /**
     * @throws Exception
     */
    public function testDeleteActionSuccess(): void
    {
        $this->client->request(HttpMethod::DELETE, NationalityController::API_ROUTE . '/' . NationalityDummy::ID);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
