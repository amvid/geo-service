<?php

declare(strict_types=1);

namespace App\Timezone\Action\Get;

interface GetTimezonesActionInterface
{
    public function run(GetTimezonesActionRequest $request): GetTimezonesActionResponse;
}