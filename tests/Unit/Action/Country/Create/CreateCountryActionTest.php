<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Country\Create;

use App\Action\Country\Create\CreateCountryAction;
use App\Action\Country\Create\CreateCountryActionRequest;
use App\Entity\Country;
use App\Entity\Currency;
use App\Entity\Region;
use App\Entity\SubRegion;
use App\Entity\Timezone;
use App\Exception\CountryAlreadyExistsException;
use App\Exception\CurrencyNotFoundException;
use App\Exception\SubRegionNotFoundException;
use App\Exception\TimezoneNotFoundException;
use App\Factory\CountryFactoryInterface;
use App\Repository\CountryRepositoryInterface;
use App\Repository\CurrencyRepositoryInterface;
use App\Repository\SubRegionRepositoryInterface;
use App\Repository\TimezoneRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateCountryActionTest extends TestCase
{
    private CountryFactoryInterface $factory;
    private CountryRepositoryInterface $countryRepository;
    private SubRegionRepositoryInterface $subRegionRepository;
    private TimezoneRepositoryInterface $timezoneRepository;
    private CurrencyRepositoryInterface $currencyRepository;
    private CreateCountryAction $action;
    private CreateCountryActionRequest $request;

    private string $title = 'Norway';
    private string $nativeTitle = 'Norge';
    private string $iso2 = 'NO';
    private string $iso3 = 'NOR';
    private string $phoneCode = '47';
    private string $numericCode = '407';
    private string $subRegionTitle = 'Northern Europe';
    private string $currency = 'NOK';
    private string $flag = '🇳🇴';
    private string $tld = '.no';
    private float $longitude = 10.0;
    private float $latitude = 62.0;
    private array $timezones = ['Europe/Oslo'];

    protected function setUp(): void
    {
        $this->factory = $this->getMockBuilder(CountryFactoryInterface::class)->getMock();
        $this->countryRepository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();
        $this->subRegionRepository = $this->getMockBuilder(SubRegionRepositoryInterface::class)->getMock();
        $this->timezoneRepository = $this->getMockBuilder(TimezoneRepositoryInterface::class)->getMock();
        $this->currencyRepository = $this->getMockBuilder(CurrencyRepositoryInterface::class)->getMock();

        $this->action = new CreateCountryAction(
            $this->factory,
            $this->countryRepository,
            $this->timezoneRepository,
            $this->currencyRepository,
            $this->subRegionRepository
        );

        $this->request = new CreateCountryActionRequest(
            $this->title,
            $this->iso2,
            $this->iso3,
            $this->phoneCode,
            $this->numericCode,
            $this->subRegionTitle,
            $this->currency,
            $this->flag,
            $this->tld,
            $this->latitude,
            $this->longitude,
            $this->timezones,
            null,
            $this->nativeTitle,
        );
    }

    public function testShouldThrowCountryAlreadyExistsExceptionIfIso2AlreadyTaken(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->iso2)
            ->willReturn(new Country());

        $this->expectException(CountryAlreadyExistsException::class);
        $this->action->run($this->request);
    }

    public function testShouldThrowSubRegionNotFoundExceptionIfNotExists(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->iso2)
            ->willReturn(null);

        $this->subRegionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->subRegionTitle)
            ->willReturn(null);

        $this->expectException(SubRegionNotFoundException::class);
        $this->action->run($this->request);
    }

    public function testShouldThrowCurrencyNotFoundExceptionIfNotExists(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->iso2)
            ->willReturn(null);

        $this->subRegionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->subRegionTitle)
            ->willReturn(new SubRegion());

        $this->currencyRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->currency)
            ->willReturn(null);

        $this->expectException(CurrencyNotFoundException::class);
        $this->action->run($this->request);
    }

    public function testShouldThrowTimezoneNotFoundExceptionIfNotExists(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->iso2)
            ->willReturn(null);

        $this->subRegionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->subRegionTitle)
            ->willReturn(new SubRegion());

        $this->currencyRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->currency)
            ->willReturn(new Currency());

        $this->timezoneRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->timezones[0])
            ->willReturn(null);

        $this->expectException(TimezoneNotFoundException::class);
        $this->action->run($this->request);
    }

    public function testShouldReturnAValidResponse(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->iso2)
            ->willReturn(null);

        $regionId = Uuid::uuid4();
        $region = new Region($regionId);
        $region->setTitle('Europe')->setCreatedAt();

        $subRegionId = Uuid::uuid4();
        $subRegion = new SubRegion($subRegionId);
        $subRegion->setTitle($this->subRegionTitle)->setRegion($region)->setCreatedAt();
        $this->subRegionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->subRegionTitle)
            ->willReturn($subRegion);

        $currencyId = Uuid::uuid4();
        $currency = new Currency($currencyId);
        $currency->setName('Norwegian Krone')->setCode('NOK')->setSymbol('kr')->setCreatedAt();
        $this->currencyRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->currency)
            ->willReturn($currency);

        $tzs = new ArrayCollection();
        $timezoneId = Uuid::uuid4();
        $timezone = new Timezone($timezoneId);
        $timezone->setCode($this->timezones[0])->setTitle($this->timezones[0])->setUtc('+02:00')->setCreatedAt();
        $tzs->add($timezone);
        $this->timezoneRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->timezones[0])
            ->willReturn($timezone);

        $countryId = Uuid::uuid4();
        $country = new Country($countryId);
        $country
            ->setTitle($this->title)
            ->setNativeTitle($this->nativeTitle)
            ->setFlag($this->flag)
            ->setPhoneCode($this->phoneCode)
            ->setNumericCode($this->numericCode)
            ->setLongitude($this->longitude)
            ->setLatitude($this->latitude)
            ->setTld($this->tld)
            ->setCurrency($currency)
            ->setSubRegion($subRegion)
            ->addTimezone($timezone)
            ->setIso3($this->iso3)
            ->setIso2($this->iso2)
            ->setCreatedAt();

        $this->factory
            ->expects($this->once())->method('setNativeTitle')->with($this->nativeTitle)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setTitle')->with($this->title)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setIso3')->with($this->iso3)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setIso2')->with($this->iso2)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setFlag')->with($this->flag)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setPhoneCode')->with($this->phoneCode)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setNumericCode')->with($this->numericCode)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setSubRegion')->with($subRegion)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setTimezones')->with($tzs)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setCurrency')->with($currency)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setTld')->with($this->tld)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setLongitude')->with($this->longitude)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setLatitude')->with($this->latitude)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setAltitude')->with(null)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('create')->willReturn($country);

        $this->countryRepository->expects($this->once())->method('save')->with($country);

        $actual = $this->action->run($this->request);

        $this->assertEquals($this->title, $actual->countryResponse->title);
        $this->assertEquals($this->nativeTitle, $actual->countryResponse->nativeTitle);
        $this->assertEquals($this->latitude, $actual->countryResponse->latitude);
        $this->assertEquals($this->iso3, $actual->countryResponse->iso3);
        $this->assertEquals($this->iso2, $actual->countryResponse->iso2);
        $this->assertEquals($this->phoneCode, $actual->countryResponse->phoneCode);
        $this->assertEquals($this->numericCode, $actual->countryResponse->numericCode);
        $this->assertEquals($this->longitude, $actual->countryResponse->longitude);
        $this->assertEquals($this->tld, $actual->countryResponse->tld);
        $this->assertEquals($this->flag, $actual->countryResponse->flag);
        $this->assertEquals(null, $actual->countryResponse->altitude);
        $this->assertEquals($subRegionId, $actual->countryResponse->subRegion->id);
        $this->assertEquals($regionId, $actual->countryResponse->subRegion->region->id);
        $this->assertEquals($currencyId, $actual->countryResponse->currency->id);
        $this->assertEquals($timezoneId, $actual->countryResponse->timezones[0]->id);
    }
}