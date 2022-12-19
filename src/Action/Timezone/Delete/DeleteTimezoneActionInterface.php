<?php

declare(strict_types=1);

namespace App\Action\Timezone\Delete;

interface DeleteTimezoneActionInterface
{
    public function run(DeleteTimezoneActionRequest $request): DeleteTimezoneActionResponse;

}
