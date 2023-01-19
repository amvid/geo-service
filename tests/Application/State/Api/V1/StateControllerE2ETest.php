<?php

declare(strict_types=1);

namespace App\Tests\Application\State\Api\V1;

use _PHPStan_980551bf2\Nette\Utils\JsonException;
use App\Application\Controller\HttpMethod;
use App\State\Controller\Api\V1\StateController;
use App\State\Entity\State;
use App\State\Repository\StateRepositoryInterface;
use App\Tests\Unit\Country\CountryDummy;
use App\Tests\Unit\State\StateDummy;
use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class StateControllerE2ETest extends WebTestCase
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
            'title' => 'Test City',
            'countryIso2' => CountryDummy::ISO2,
            'code' => 'TST',
            'type' => 'state',
            'longitude' => 11,
            'latitude' => 22,
            'altitude' => 10,
        ];

        $this->client->request(
            HttpMethod::POST,
            StateController::API_ROUTE,
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
            'code' => 'TST',
            'longitude' => 11,
            'latitude' => 22,
            'altitude' => 10,
        ];

        $this->client->request(
            HttpMethod::POST,
            StateController::API_ROUTE,
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
        /** @var State $state */
        $state = self::getContainer()->get(StateRepositoryInterface::class)->findByTitle(StateDummy::TITLE);

        $content = ['title' => 'Updated Title'];

        $this->client->request(
            HttpMethod::PUT,
            StateController::API_ROUTE . '/' . $state->getId()->toString(),
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
    public function testUpdateActionStateNotFound(): void
    {
        $content = ['title' => 'Updated Title'];
        $id = StateDummy::ID;
        $this->client->request(
            HttpMethod::PUT,
            StateController::API_ROUTE . '/' . $id,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertEquals(
            "State '$id' not found.",
            $this->client->getResponse()->getContent()
        );
    }

    /**
     * @throws Exception
     */
    public function testDeleteActionSuccess(): void
    {
        $this->client->request(HttpMethod::DELETE, StateController::API_ROUTE . '/' . StateDummy::ID);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
