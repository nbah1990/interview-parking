<?php

namespace App\Interview\Parking\Application\Dto;

use App\Interview\Parking\Domain\ValueObjects\Uuid;

class BookingSpotDto
{
    public function __construct(
        private Uuid $uuid
    ){}

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }
}
