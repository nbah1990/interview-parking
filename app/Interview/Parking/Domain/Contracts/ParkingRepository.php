<?php

namespace App\Interview\Parking\Domain\Contracts;

use App\Interview\Parking\Domain\Entities\Parking;
use App\Interview\Parking\Domain\ValueObjects\Uuid;

interface ParkingRepository
{
    public function get(Uuid $uuid): ?Parking;
    // @TODO persist
}
