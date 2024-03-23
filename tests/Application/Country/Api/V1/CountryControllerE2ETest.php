<?php

declare(strict_types=1);

namespace App\Tests\Application\Country\Api\V1;

use _PHPStan_980551bf2\Nette\Utils\JsonException;
use App\Application\Controller\HttpMethod;
use App\Country\Controller\Api\V1\CountryController;
use App\Country\Entity\Country;
use App\Country\Repository\CountryRepositoryInterface;
use App\Tests\Unit\Country\CountryDummy;
use App\Tests\Unit\SubRegion\SubRegionDummy;
use App\Tests\Unit\Timezone\TimezoneDummy;
use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CountryControllerE2ETest extends WebTestCase
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
            'title' => 'Test Title',
            'nativeTitle' => 'Native Test',
            'iso2' => '00',
            'iso3' => '000',
            'phoneCode' => '000',
            'numericCode' => '000',
            'subRegion' => SubRegionDummy::TITLE,
            'currencyCode' => 'USD',
            'flag' => '$',
            'tld' => '.test',
            'timezones' => [TimezoneDummy::CODE],
            'longitude' => 11,
            'latitude' => 22,
            'altitude' => 10,
        ];

        $this->client->request(
            HttpMethod::POST,
            CountryController::API_ROUTE,
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
            'iso2' => '00',
            'iso3' => '000',
            'phoneCode' => '000',
            'numericCode' => '000',
            'subRegion' => SubRegionDummy::TITLE,
            'currencyCode' => 'USD',
            'flag' => '$',
            'tld' => '.test',
            'timezones' => [TimezoneDummy::CODE],
            'longitude' => 11,
            'latitude' => 22,
            'altitude' => 10,
        ];

        $this->client->request(
            HttpMethod::POST,
            CountryController::API_ROUTE,
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
        /** @var Country $country */
        $country = self::getContainer()->get(CountryRepositoryInterface::class)->findByIso2(CountryDummy::ISO2);

        $content = ['title' => 'Updated Title'];

        $this->client->request(
            HttpMethod::PUT,
            CountryController::API_ROUTE . '/' . $country->getId()->toString(),
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
    public function testUpdateActionCountryNotFound(): void
    {
        $content = ['title' => 'Updated Title'];
        $id = CountryDummy::ID;
        $this->client->request(
            HttpMethod::PUT,
            CountryController::API_ROUTE . '/' . $id,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertEquals(
            "{\"error\":\"Country '$id' not found.\"}",
            $this->client->getResponse()->getContent()
        );
    }

    /**
     * @throws Exception
     */
    public function testDeleteActionSuccess(): void
    {
        $this->client->request(HttpMethod::DELETE, CountryController::API_ROUTE . '/' . CountryDummy::ID);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGetPhoneCodeActionSuccess(): void
    {
        $expectedJson = '[{"title":"Updated Title","iso2":"US","iso3":"USA","phoneCode":"1","flag":"\ud83c\uddfa\ud83c\uddf8"}]';
        $this->client->request(HttpMethod::GET, CountryController::API_ROUTE . '/phone-codes?limit=1&offset=0&phoneCode=1');
        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertJson($this->client->getResponse()->getContent());
        self::assertEquals($expectedJson, $this->client->getResponse()->getContent());
    }
}
