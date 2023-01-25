<?php

declare(strict_types=1);

namespace App\Region\Action\Get;

interface GetRegionsActionInterface
{
    public function run(GetRegionsActionRequest $request): GetRegionsActionResponse;
}
