<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Country\Get;

use App\Action\Country\Get\GetCountriesAction;
use App\Action\Country\Get\GetCountriesActionRequest;
use App\Entity\Country;
use App\Entity\Currency;
use App\Exception\CurrencyNotFoundException;
use App\Region\Entity\Region;
use App\Repository\CountryRepositoryInterface;
use App\Repository\CurrencyRepositoryInterface;
use App\SubRegion\Entity\SubRegion;
use App\SubRegion\Exception\SubRegionNotFoundException;
use App\SubRegion\Repository\SubRegionRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class GetCountryActionTest extends TestCase
{
    private CountryRepositoryInterface $countryRepository;
    private SubRegionRepositoryInterface $subRegionRepository;
    private CurrencyRepositoryInterface $currencyRepository;

    private GetCountriesActionRequest $request;

    private UuidInterface $countryId;
    private string $title = 'Norway';
    private string $nativeTitle = 'Norge';
    private string $iso2 = 'NO';
    private string $iso3 = 'NOR';
    private string $phoneCode = '47';
    private string $numericCode = '407';
    private string $subRegionTitle = 'Northern Europe';
    private string $currency = 'NOK';
    private string $tld = '.no';
    private array $timezones = ['Europe/Oslo'];
    private int $limit = 10;
    private int $offset = 0;

    protected function setUp(): void
    {
        $this->countryRepository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();
        $this->subRegionRepository = $this->getMockBuilder(SubRegionRepositoryInterface::class)->getMock();
        $this->currencyRepository = $this->getMockBuilder(CurrencyRepositoryInterface::class)->getMock();

        $this->request = new GetCountriesActionRequest();
        $this->request->timezones = $this->timezones;
        $this->request->tld = $this->tld;
        $this->request->currencyCode = $this->currency;
        $this->request->subRegion = $this->subRegionTitle;
        $this->request->numericCode = $this->numericCode;
        $this->request->phoneCode = $this->phoneCode;
        $this->request->iso3 = $this->iso3;
        $this->request->iso2 = $this->iso2;
        $this->request->title = $this->title;
        $this->request->nativeTitle = $this->nativeTitle;
        $this->request->limit = $this->limit;
        $this->request->offset = $this->offset;
        $this->countryId = Uuid::uuid4();
        $this->request->id = $this->countryId;
    }

    public function testShouldThrowCurrencyNotFoundExceptionIfNotExists(): void
    {
        $this->currencyRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with()
            ->willReturn(null);

        $action = new GetCountriesAction(
            $this->countryRepository,
            $this->currencyRepository,
            $this->subRegionRepository,
        );

        $this->expectException(CurrencyNotFoundException::class);
        $this->expectExceptionMessage("Currency '$this->currency' not found.");
        $action->run($this->request);
    }

    public function testShouldThrowSubRegionNotFoundExceptionIfNotExists(): void
    {
        $this->currencyRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->currency)
            ->willReturn(new Currency());

        $this->subRegionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->subRegionTitle)
            ->willReturn(null);

        $action = new GetCountriesAction(
            $this->countryRepository,
            $this->currencyRepository,
            $this->subRegionRepository,
        );

        $this->expectException(SubRegionNotFoundException::class);
        $this->expectExceptionMessage("Sub region '$this->subRegionTitle' not found.");
        $action->run($this->request);
    }

    public function testShouldReturnCountryResponse(): void
    {
        $currencyId = Uuid::uuid4();
        $currency = new Currency($currencyId);
        $currency->setName('Norwegian Krone')->setCode('NOK')->setSymbol('kr')->setCreatedAt();

        $this->currencyRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->currency)
            ->willReturn($currency);

        $regionId = Uuid::uuid4();
        $region = new Region($regionId);
        $region->setTitle('Europe')->setCreatedAt();

        $subRegionId = Uuid::uuid4();
        $subRegion = new SubRegion($subRegionId);
        $subRegion->setTitle('Northern Europe')->setRegion($region)->setCreatedAt();

        $this->subRegionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->subRegionTitle)
            ->willReturn($subRegion);

        $country = new Country($this->countryId);
        $country
            ->setTitle($this->title)
            ->setNativeTitle($this->nativeTitle)
            ->setIso2($this->iso2)
            ->setIso3($this->iso3)
            ->setPhoneCode($this->phoneCode)
            ->setNumericCode($this->numericCode)
            ->setTld($this->tld)
            ->setCurrency($currency)
            ->setSubRegion($subRegion)
            ->setFlag('flag')
            ->setLongitude(10)
            ->setLatitude(62)
            ->setCreatedAt();


        $this->countryRepository
            ->expects($this->once())
            ->method('list')
            ->with(
                $this->offset,
                $this->limit,
                $this->countryId,
                $this->title,
                $this->nativeTitle,
                $this->iso2,
                $this->iso3,
                $this->phoneCode,
                $this->numericCode,
                $this->tld,
                $currency,
                $subRegion,
            )
            ->willReturn([$country]);

        $action = new GetCountriesAction(
            $this->countryRepository,
            $this->currencyRepository,
            $this->subRegionRepository,
        );

        $actual = $action->run($this->request);

        $this->assertCount(1, $actual->response);
        $this->assertEquals($this->countryId, $actual->response[0]->id);
        $this->assertEquals($this->title, $actual->response[0]->title);
        $this->assertEquals($this->nativeTitle, $actual->response[0]->nativeTitle);
        $this->assertEquals($this->iso2, $actual->response[0]->iso2);
        $this->assertEquals($this->iso3, $actual->response[0]->iso3);
        $this->assertEquals($this->phoneCode, $actual->response[0]->phoneCode);
        $this->assertEquals($this->numericCode, $actual->response[0]->numericCode);
        $this->assertEquals($this->tld, $actual->response[0]->tld);
        $this->assertEquals($this->currency, $actual->response[0]->currency->code);
        $this->assertEquals($this->subRegionTitle, $actual->response[0]->subRegion->title);
    }
}