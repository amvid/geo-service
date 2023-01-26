<?php

declare(strict_types=1);

namespace App\Currency\Action\Create;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateCurrencyActionRequest
{
    #[NotBlank]
    #[Length(min: 1, max: 100)]
    public string $name;

    #[NotBlank]
    #[Length(min: 1, max: 3)]
    public string $code;

    #[NotBlank]
    #[Length(min: 1, max: 10)]
    public string $symbol;
}
