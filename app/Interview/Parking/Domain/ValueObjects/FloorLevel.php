<?php

namespace App\Interview\Parking\Domain\ValueObjects;

use JetBrains\PhpStorm\Pure;

class FloorLevel
{
    private function __construct(
        private int $value
    )
    {
    }

    #[Pure] public static function create(int $level): self
    {
        return new self($level);
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
