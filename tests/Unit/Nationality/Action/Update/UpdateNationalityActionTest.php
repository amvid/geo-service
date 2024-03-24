<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality\Action\Update;

use App\Nationality\Action\Update\UpdateNationalityAction;
use App\Nationality\Action\Update\UpdateNationalityActionRequest;
use App\Nationality\Entity\Nationality;
use App\Nationality\Exception\NationalityNotFoundException;
use App\Nationality\Repository\NationalityRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateNationalityActionTest extends TestCase
{
    private NationalityRepositoryInterface $nationalityRepository;

    protected function setUp(): void
    {
        $this->nationalityRepository = $this->getMockBuilder(NationalityRepositoryInterface::class)->getMock();
    }

    public function testShouldUpdateNationalityAndReturnResponse(): void
    {
        $title = 'American';
        $updateTitle = 'Norwegian';
        $id = Uuid::uuid7();

        $nationality = new Nationality($id);
        $nationality->setTitle($title)->setCreatedAt();

        $req = new UpdateNationalityActionRequest();
        $req->setTitle($updateTitle);

        $this->nationalityRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($nationality);

        $this->nationalityRepository
            ->expects($this->once())
            ->method('save')
            ->with($nationality, true);

        $action = new UpdateNationalityAction($this->nationalityRepository);

        try {
            $actual = $action->run($req, $id);
        } catch (NationalityNotFoundException $e) {
            $this->fail('Must not throw an error: ' . $e->getMessage());
        }

        $this->assertEquals($updateTitle, $actual->nationalityResponse->title);
        $this->assertEquals($id, $actual->nationalityResponse->id);
    }

    public function testShouldThrowNotFoundExceptionIfNationalityNotFound(): void
    {
        $id = Uuid::uuid7();
        $req = new UpdateNationalityActionRequest();

        $this->nationalityRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $action = new UpdateNationalityAction($this->nationalityRepository);

        $this->expectException(NationalityNotFoundException::class);
        $action->run($req, $id);
    }
}
