<?php

declare(strict_types=1);

namespace App\Timezone\Action\Create;

interface CreateTimezoneActionInterface
{
    public function run(CreateTimezoneActionRequest $request): CreateTimezoneActionResponse;
}
