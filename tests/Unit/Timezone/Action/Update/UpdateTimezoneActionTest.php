<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timezone\Action\Update;

use App\Timezone\Action\Update\UpdateTimezoneAction;
use App\Timezone\Action\Update\UpdateTimezoneActionRequest;
use App\Timezone\Entity\Timezone;
use App\Timezone\Exception\TimezoneNotFoundException;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateTimezoneActionTest extends TestCase
{
    private TimezoneRepositoryInterface $timezoneRepository;

    protected function setUp(): void
    {
        $this->timezoneRepository = $this->getMockBuilder(TimezoneRepositoryInterface::class)->getMock();
    }

    public function testShouldUpdateTimezoneAndReturnResponse(): void
    {
        $id = Uuid::uuid4();
        $title = 'Europe/Oslo (GMT+02:00)';
        $code = 'Europe/Oslo1';
        $utc = '+02:00';

        $updateTitle = 'Europe/Oslo (GMT+01:00)';
        $updateCode = 'Europe/Oslo';
        $updateUtc = '+01:00';

        $tz = new Timezone($id);
        $tz
            ->setTitle($title)
            ->setCode($code)
            ->setUtc($utc)
            ->setCreatedAt();

        $req = new UpdateTimezoneActionRequest();
        $req
            ->setTitle($updateTitle)
            ->setUtc($updateUtc)
            ->setCode($updateCode);

        $this->timezoneRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($tz);

        $this->timezoneRepository
            ->expects($this->once())
            ->method('save')
            ->with($tz, true);

        $action = new UpdateTimezoneAction($this->timezoneRepository);

        try {
            $actual = $action->run($req, $id);
        } catch (TimezoneNotFoundException $e) {
            $this->fail('Must not throw an error: ' . $e->getMessage());
        }

        $this->assertEquals($updateTitle, $actual->timezoneResponse->title);
        $this->assertEquals($updateCode, $actual->timezoneResponse->code);
        $this->assertEquals($updateUtc, $actual->timezoneResponse->utc);
        $this->assertEquals($id, $actual->timezoneResponse->id);
    }

    public function testShouldThrowNotFoundExceptionIfRegionNotFound(): void
    {
        $id = Uuid::uuid7();
        $req = new UpdateTimezoneActionRequest();

        $this->timezoneRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $action = new UpdateTimezoneAction($this->timezoneRepository);

        $this->expectException(TimezoneNotFoundException::class);
        $action->run($req, $id);
    }
}
