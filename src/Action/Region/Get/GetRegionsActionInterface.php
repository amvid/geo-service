<?php

declare(strict_types=1);

namespace App\Action\Region\Get;

interface GetRegionsActionInterface
{
    public function run(GetRegionsActionRequest $request): GetRegionsActionResponse;
}