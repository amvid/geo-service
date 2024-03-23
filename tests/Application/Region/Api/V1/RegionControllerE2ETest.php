<?php

declare(strict_types=1);

namespace App\Tests\Application\Region\Api\V1;

use App\Application\Controller\HttpMethod;
use App\Region\Controller\Api\V1\RegionController;
use App\Region\Entity\Region;
use App\Region\Repository\RegionRepositoryInterface;
use App\Tests\Unit\Region\RegionDummy;
use Exception;
use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegionControllerE2ETest extends WebTestCase
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
            'title' => 'Europe',
        ];

        $this->client->request(
            HttpMethod::POST,
            RegionController::API_ROUTE,
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
            "wrongParam": "Europe"
        }';

        $this->client->request(HttpMethod::POST, RegionController::API_ROUTE, content: $content);

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        self::assertTrue(str_contains($this->client->getResponse()->getContent(), 'This value should not be blank'));
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testUpdateActionSuccess(): void
    {
        /** @var Region $region */
        $region = self::getContainer()
            ->get(RegionRepositoryInterface::class)
            ->findByTitle(RegionDummy::TITLE);

        $content = ['title' => 'Updated Title'];

        $this->client->request(
            HttpMethod::PUT,
            RegionController::API_ROUTE . '/' . $region->getId()->toString(),
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
    public function testUpdateActionRegionNotFound(): void
    {
        $content = ['title' => 'Updated Title'];
        $id = RegionDummy::ID;
        $this->client->request(
            HttpMethod::PUT,
            RegionController::API_ROUTE . '/' . $id,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertEquals(
            "{\"error\":\"Region '$id' not found.\"}",
            $this->client->getResponse()->getContent()
        );
    }

    /**
     * @throws Exception
     */
    public function testDeleteActionSuccess(): void
    {
        $this->client->request(HttpMethod::DELETE, RegionController::API_ROUTE . '/' . RegionDummy::ID);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
