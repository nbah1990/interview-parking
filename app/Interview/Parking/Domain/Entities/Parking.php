<?php

namespace App\Interview\Parking\Domain\Entities;

use App\Interview\Parking\Domain\Exception\NotEnoughFreeSpots;
use App\Interview\Parking\Domain\ValueObjects\Uuid;
use RuntimeException;

class Parking
{
    public function __construct(
        private Uuid            $uuid,
        private FloorCollection $floors
    )
    {
    }

    /**
     * @throws \App\Interview\Parking\Domain\Exception\NotEnoughFreeSpots
     * @throws \RuntimeException
     */
    public function carBookSpot(): self
    {
        $spotToBook = $this
            ->getFirstAvailableFloorByFreeSpotsCount($this->floors, 1)
            ->getSpots()
            ->getFirstFree();
        if (!$spotToBook) {
            throw new RuntimeException('Unexpected exception');
        }

        $spotToBook->book();

        return $this;
    }

    /**
     * @throws \App\Interview\Parking\Domain\Exception\NotEnoughFreeSpots
     */
    private function getFirstAvailableFloorByFreeSpotsCount(FloorCollection $floorCollection, int $count): Floor
    {
        $floor = $floorCollection->getAvailableFloors($count)->getFirst();
        if (!$floor) {
            throw new NotEnoughFreeSpots('Sorry. There is no free spots');
        }

        return $floor;
    }

    /**
     * @throws \App\Interview\Parking\Domain\Exception\NotEnoughFreeSpots
     */
    public function truckBookSpots(): self
    {
        $truckFloors = $this->floors->getAvailableForTruck();
        $spots = $this->getFirstAvailableFloorByFreeSpotsCount($truckFloors, 2)->getSpots();

        $this->bookSpot($spots->getFirstFree());
        $this->bookSpot($spots->getFirstFree());

        return $this;
    }

    private function bookSpot(?Spot $spot): void
    {
        if (!$spot) {
            throw new RuntimeException('Unexpected exception');
        }
        $spot->book();
    }
}
