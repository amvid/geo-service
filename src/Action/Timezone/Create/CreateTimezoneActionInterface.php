<?php

declare(strict_types=1);

namespace App\Action\Timezone\Create;

interface CreateTimezoneActionInterface
{
    public function run(CreateTimezoneActionRequest $request): CreateTimezoneActionResponse;
}
