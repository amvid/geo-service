<?php

declare(strict_types=1);

namespace App\Tests\Unit\Country\Action\Update;

use App\Country\Action\Update\UpdateCountryAction;
use App\Country\Action\Update\UpdateCountryActionRequest;
use App\Country\Entity\Country;
use App\Country\Exception\CountryNotFoundException;
use App\Country\Factory\CountryFactoryInterface;
use App\Country\Repository\CountryRepositoryInterface;
use App\Currency\Entity\Currency;
use App\Currency\Exception\CurrencyNotFoundException;
use App\Currency\Repository\CurrencyRepositoryInterface;
use App\SubRegion\Entity\SubRegion;
use App\SubRegion\Exception\SubRegionNotFoundException;
use App\SubRegion\Repository\SubRegionRepositoryInterface;
use App\Tests\Unit\Currency\CurrencyDummy;
use App\Tests\Unit\Region\RegionDummy;
use App\Tests\Unit\SubRegion\SubRegionDummy;
use App\Tests\Unit\Timezone\TimezoneDummy;
use App\Timezone\Exception\TimezoneNotFoundException;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UpdateCountryActionTest extends TestCase
{
    private CountryFactoryInterface $factory;
    private CountryRepositoryInterface $countryRepository;
    private SubRegionRepositoryInterface $subRegionRepository;
    private TimezoneRepositoryInterface $timezoneRepository;
    private CurrencyRepositoryInterface $currencyRepository;
    private UpdateCountryAction $action;
    private UpdateCountryActionRequest $request;

    private UuidInterface $id;
    private string $subRegion = 'Northern Europe';
    private string $currencyCode = 'NOK';
    private string $title = 'Norway';
    private string $nativeTitle = 'Norge';
    private string $iso2 = 'NO';
    private string $iso3 = 'NOR';
    private string $phoneCode = '47';
    private string $numericCode = '407';
    private string $flag = '🇳🇴';
    private string $tld = '.no';
    private float $longitude = 10.0;
    private float $latitude = 62.0;

    private string $updateTitle = 'Updated Norway';

    private array $timezones = ['Europe/Oslo'];

    protected function setUp(): void
    {
        $this->factory = $this->getMockBuilder(CountryFactoryInterface::class)->getMock();
        $this->countryRepository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();
        $this->subRegionRepository = $this->getMockBuilder(SubRegionRepositoryInterface::class)->getMock();
        $this->timezoneRepository = $this->getMockBuilder(TimezoneRepositoryInterface::class)->getMock();
        $this->currencyRepository = $this->getMockBuilder(CurrencyRepositoryInterface::class)->getMock();

        $this->action = new UpdateCountryAction(
            $this->factory,
            $this->countryRepository,
            $this->timezoneRepository,
            $this->currencyRepository,
            $this->subRegionRepository
        );

        $this->id = Uuid::uuid4();
        $this->request = new UpdateCountryActionRequest();
        $this->request->currencyCode = $this->currencyCode;
        $this->request->subRegion = $this->subRegion;
        $this->request->timezones = $this->timezones;
        $this->request->title = $this->updateTitle;
        $this->request->nativeTitle = $this->nativeTitle;
        $this->request->flag = $this->flag;
        $this->request->phoneCode = $this->phoneCode;
        $this->request->tld = $this->tld;
        $this->request->longitude = $this->longitude;
        $this->request->latitude = $this->latitude;
    }

    public function testShouldThrowCountryNotFoundExceptionIfCountryNotFoundById(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn(null);

        $this->expectException(CountryNotFoundException::class);
        $this->action->run($this->request, $this->id);
    }

    public function testShouldThrowSubRegionNotFoundExceptionIfNotExists(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn(new Country());

        $this->subRegionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->subRegion)
            ->willReturn(null);

        $this->expectException(SubRegionNotFoundException::class);
        $this->action->run($this->request, $this->id);
    }

    public function testShouldThrowCurrencyNotFoundExceptionIfNotExists(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn(new Country());

        $this->subRegionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->subRegion)
            ->willReturn(new SubRegion());

        $this->currencyRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->currencyCode)
            ->willReturn(null);

        $this->expectException(CurrencyNotFoundException::class);
        $this->action->run($this->request, $this->id);
    }

    public function testShouldThrowTimezoneNotFoundExceptionIfNotExists(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn(new Country());

        $this->subRegionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->subRegion)
            ->willReturn(new SubRegion());

        $this->currencyRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->currencyCode)
            ->willReturn(new Currency());

        $this->timezoneRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->timezones[0])
            ->willReturn(null);

        $this->expectException(TimezoneNotFoundException::class);
        $this->action->run($this->request, $this->id);
    }

    public function testShouldReturnAValidResponse(): void
    {
        $country = new Country($this->id);
        $country
            ->setTitle($this->title)
            ->setIso2($this->iso2)
            ->setIso3($this->iso3)
            ->setNumericCode($this->numericCode)
            ->setNativeTitle($this->nativeTitle)
            ->setFlag($this->flag)
            ->setPhoneCode($this->phoneCode)
            ->setLongitude($this->longitude)
            ->setLatitude($this->latitude)
            ->setTld($this->tld)
            ->setCreatedAt();

        $this->countryRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn($country);

        $subRegion = SubRegionDummy::get();

        $this->subRegionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->subRegion)
            ->willReturn($subRegion);

        $country->setSubRegion($subRegion);

        $currency = CurrencyDummy::get();
        $this->currencyRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->currencyCode)
            ->willReturn($currency);

        $country->setCurrency($currency);

        $tzs = new ArrayCollection();
        $timezone = TimezoneDummy::get();
        $tzs->add($timezone);
        $this->timezoneRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->timezones[0])
            ->willReturn($timezone);

        $country->addTimezone($timezone);
        $country->setTitle($this->updateTitle);

        $this->factory
            ->expects($this->once())->method('setNativeTitle')->with($this->nativeTitle)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setFlag')->with($this->flag)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setPhoneCode')->with($this->phoneCode)->willReturn($this->factory);
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
            ->expects($this->once())->method('create')->willReturn($country);

        $this->countryRepository->expects($this->once())->method('save')->with($country, true);

        $actual = $this->action->run($this->request, $this->id);

        $this->assertEquals($this->updateTitle, $actual->countryResponse->title);
        $this->assertEquals($this->nativeTitle, $actual->countryResponse->nativeTitle);
        $this->assertEquals($this->latitude, $actual->countryResponse->latitude);
        $this->assertEquals($this->phoneCode, $actual->countryResponse->phoneCode);
        $this->assertEquals($this->longitude, $actual->countryResponse->longitude);
        $this->assertEquals($this->tld, $actual->countryResponse->tld);
        $this->assertEquals($this->flag, $actual->countryResponse->flag);
        $this->assertEquals(null, $actual->countryResponse->altitude);
        $this->assertEquals(SubRegionDummy::ID, $actual->countryResponse->subRegion->id->toString());
        $this->assertEquals(RegionDummy::ID, $actual->countryResponse->subRegion->region->id->toString());
        $this->assertEquals(CurrencyDummy::ID, $actual->countryResponse->currency->id->toString());
        $this->assertEquals(TimezoneDummy::ID, $actual->countryResponse->timezones[0]->id->toString());
    }
}
