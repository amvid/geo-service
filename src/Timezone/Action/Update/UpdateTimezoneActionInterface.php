<?php

declare(strict_types=1);

namespace App\Timezone\Action\Update;

use Ramsey\Uuid\UuidInterface;

interface UpdateTimezoneActionInterface
{
    public function run(UpdateTimezoneActionRequest $request, UuidInterface $id): UpdateTimezoneActionResponse;
}
