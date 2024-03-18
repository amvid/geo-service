<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality\Action\Get;

use App\Nationality\Action\Get\GetNationalitiesAction;
use App\Nationality\Action\Get\GetNationalitiesActionRequest;
use App\Nationality\Entity\Nationality;
use App\Nationality\Repository\NationalityRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetNationalitiesActionTest extends TestCase
{
    private NationalityRepositoryInterface $repository;
    private Nationality $norwegian;
    private Nationality $american;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(NationalityRepositoryInterface::class)->getMock();

        $id1 = Uuid::uuid7();
        $id2 = Uuid::uuid7();

        $this->american = new Nationality($id1);
        $this->american->setTitle('American');
        $this->american->setCreatedAt();

        $this->norwegian = new Nationality($id2);
        $this->norwegian->setTitle('Norwegian');
        $this->norwegian->setCreatedAt();
    }

    public function testShouldReturnResponseArrayOfNationalities(): void
    {
        $limit = 10;
        $offset = 0;

        $nationalities = [$this->american, $this->norwegian];

        $this->repository
            ->expects($this->once())
            ->method('list')
            ->with($offset, $limit)
            ->willReturn($nationalities);

        $req = new GetNationalitiesActionRequest();
        $req->limit = $limit;
        $req->offset = $offset;

        $action = new GetNationalitiesAction($this->repository);
        $actual = $action->run($req);

        $this->assertCount(2, $actual->response);
        $this->assertEquals($this->american->getId(), $actual->response[0]->id);
        $this->assertEquals($this->norwegian->getId(), $actual->response[1]->id);
    }
}
