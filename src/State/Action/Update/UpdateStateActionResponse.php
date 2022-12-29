<?php

declare(strict_types=1);

namespace App\State\Action\Update;

use App\State\Controller\Response\StateResponse;
use App\State\Entity\State;

class UpdateStateActionResponse
{
    public StateResponse $state;

    public function __construct(State $state)
    {
        $this->state = new StateResponse($state);
    }
}