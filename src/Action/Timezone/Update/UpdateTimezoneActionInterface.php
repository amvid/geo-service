<?php

declare(strict_types=1);

namespace App\Action\Timezone\Update;

interface UpdateTimezoneActionInterface
{
    public function run(UpdateTimezoneActionRequest $request): UpdateTimezoneActionResponse;
}