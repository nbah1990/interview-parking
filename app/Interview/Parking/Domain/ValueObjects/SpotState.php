<?php

namespace App\Interview\Parking\Domain\ValueObjects;

class SpotState
{
    private const FREE = 'free';
    private const BOOKED = 'booked';

    private function __construct(
        private string $state
    )
    {
    }

    public static function makeFree(): self
    {
        return new self(self::FREE);
    }

    public static function makeBooked(): self
    {
        return new self(self::BOOKED);
    }

    public function isFree(): bool
    {
        return $this->state === self::FREE;
    }
}
