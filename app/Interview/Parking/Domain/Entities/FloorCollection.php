<?php

namespace App\Interview\Parking\Domain\Entities;

use App\Interview\Parking\Domain\ValueObjects\FloorLevel;
use App\Interview\Parking\Domain\ValueObjects\Uuid;
use Illuminate\Support\Arr;

class FloorCollection
{
    private array $items = [];

    public function __construct(array $items)
    {
        array_walk($items, fn(Floor $item) => $this->add($item));
    }

    public function add(Floor $item): self
    {
        $this->items[$item->getUuid()->getValue()] = $item;

        return $this;
    }

    public static function generateEmpty(int $levels): self
    {
        return new self(
            items: array_map(
                static fn($floorLevel) => new Floor(
                    uuid: Uuid::create(),
                    level: FloorLevel::create($floorLevel),
                    spots: SpotCollection::generateEmpty()
                ),
                range(1, $levels)
            )
        );
    }

    public function getAvailableFloors(int $neededSpots): FloorCollection
    {
        return new self(array_filter($this->items, static fn(Floor $item) => $item->getSpots()->getFreeSpots()->count() >= $neededSpots));
    }

    public function getAvailableForTruck(): FloorCollection
    {
        return new self(array_filter($this->items, static fn(Floor $item) => $item->isTruckAllowed()));
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getFirst(): ?Floor
    {
        return count($this->items) ? Arr::first($this->items) : null;
    }
}
