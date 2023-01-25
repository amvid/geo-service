<?php

declare(strict_types=1);

namespace App\State\Action\Get;

interface GetStatesActionInterface
{
    public function run(GetStatesActionRequest $request): GetStatesActionResponse;
}
