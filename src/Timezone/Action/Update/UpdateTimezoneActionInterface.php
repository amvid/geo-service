<?php

declare(strict_types=1);

namespace App\Timezone\Action\Update;

interface UpdateTimezoneActionInterface
{
    public function run(UpdateTimezoneActionRequest $request): UpdateTimezoneActionResponse;
}