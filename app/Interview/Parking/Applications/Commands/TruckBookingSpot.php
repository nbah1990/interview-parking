<?php

namespace App\Interview\Parking\Applications\Commands;

use App\Interview\Parking\Applications\Dto\BookingSpotDto;
use App\Interview\Parking\Domain\Contracts\ParkingRepository;
use App\Interview\Parking\Domain\Exception\NotEnoughFreeSpots;
use App\Interview\Parking\Domain\Exception\ParkingNotFound;

class TruckBookingSpot
{
    public function __construct(
        private ParkingRepository $parkingRepository
    ){

    }

    /**
     * @throws \App\Interview\Parking\Domain\Exception\ParkingNotFound
     */
    public function handle(BookingSpotDto $dto): bool
    {
        $parking = $this->parkingRepository->get(uuid: $dto->getUuid());
        if (!$parking) {
            throw new ParkingNotFound('Parking not found');
        }

        try {
            $parking->truckBookSpots();
        } catch (NotEnoughFreeSpots) {
            return false;
        }

        return true;
    }
}
