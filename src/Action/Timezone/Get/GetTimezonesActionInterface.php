<?php

declare(strict_types=1);

namespace App\Action\Timezone\Get;

interface GetTimezonesActionInterface
{
    public function run(GetTimezonesActionRequest $request): GetTimezonesActionResponse;
}