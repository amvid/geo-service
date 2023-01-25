<?php

declare(strict_types=1);

namespace App\Timezone\Action\Delete;

interface DeleteTimezoneActionInterface
{
    public function run(DeleteTimezoneActionRequest $request): DeleteTimezoneActionResponse;
}
