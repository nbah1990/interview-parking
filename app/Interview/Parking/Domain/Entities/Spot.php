<?php

namespace App\Interview\Parking\Domain\Entities;

use App\Interview\Parking\Domain\ValueObjects\SpotState;
use App\Interview\Parking\Domain\ValueObjects\Uuid;

class Spot
{
    public function __construct(
        private Uuid      $uuid,
        private SpotState $state
    )
    {
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getState(): SpotState
    {
        return $this->state;
    }

    public function book(): self
    {
        $this->state = SpotState::makeBooked();

        return $this;
    }
}
