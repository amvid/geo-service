<?php

declare(strict_types=1);

namespace App\Tests\Application\SubRegion\Api\V1;

use App\Application\Controller\HttpMethod;
use App\SubRegion\Controller\Api\V1\SubRegionController;
use App\SubRegion\Entity\SubRegion;
use App\SubRegion\Repository\SubRegionRepositoryInterface;
use App\Tests\Unit\SubRegion\SubRegionDummy;
use Exception;
use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SubRegionControllerE2ETest extends WebTestCase
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
            'title' => 'North America',
            'regionTitle' => 'America',
        ];

        $this->client->request(
            HttpMethod::POST,
            SubRegionController::API_ROUTE,
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
            "title": "North America"
        }';

        $this->client->request(HttpMethod::POST, SubRegionController::API_ROUTE, content: $content);

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        self::assertTrue(str_contains($this->client->getResponse()->getContent(), 'This value should not be blank'));
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testUpdateActionSuccess(): void
    {
        /** @var SubRegion $subRegion */
        $subRegion = self::getContainer()
            ->get(SubRegionRepositoryInterface::class)
            ->findByTitle(SubRegionDummy::TITLE);

        $content = ['title' => 'Updated Title'];

        $this->client->request(
            HttpMethod::PUT,
            SubRegionController::API_ROUTE . '/' . $subRegion->getId()->toString(),
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
    public function testUpdateActionSubRegionNotFound(): void
    {
        $content = ['title' => 'Updated Title'];
        $id = SubRegionDummy::ID;
        $this->client->request(
            HttpMethod::PUT,
            SubRegionController::API_ROUTE . '/' . $id,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertEquals(
            "Sub region '$id' not found.",
            $this->client->getResponse()->getContent()
        );
    }

    /**
     * @throws Exception
     */
    public function testDeleteActionSuccess(): void
    {
        $this->client->request(HttpMethod::DELETE, SubRegionController::API_ROUTE . '/' . SubRegionDummy::ID);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
