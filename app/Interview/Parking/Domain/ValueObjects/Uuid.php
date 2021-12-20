<?php

namespace App\Interview\Parking\Domain\ValueObjects;

use Illuminate\Support\Str;

class Uuid
{
    public function __construct(
        private string $value
    )
    {
    }

    public static function create(): self
    {
        return new self(Str::uuid());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
