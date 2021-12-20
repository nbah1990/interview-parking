<?php

namespace App\Interview\Parking\Domain\Entities;

use App\Interview\Parking\Domain\ValueObjects\FloorLevel;
use App\Interview\Parking\Domain\ValueObjects\Uuid;
use JetBrains\PhpStorm\Pure;

class Floor
{
    public function __construct(
        private Uuid           $uuid,
        private FloorLevel     $level,
        private SpotCollection $spots
    )
    {
    }

    #[Pure] public function isTruckAllowed(): bool
    {
        return $this->level->getValue() < 2;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getSpots(): SpotCollection
    {
        return $this->spots;
    }

}
