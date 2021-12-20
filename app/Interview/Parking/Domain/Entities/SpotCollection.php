<?php

namespace App\Interview\Parking\Domain\Entities;

use App\Interview\Parking\Domain\ValueObjects\SpotState;
use App\Interview\Parking\Domain\ValueObjects\Uuid;
use JetBrains\PhpStorm\Pure;

class SpotCollection
{
    /** @var \App\Interview\Parking\Domain\Entities\Spot[] */
    private array $items = [];

    public function __construct(array $items)
    {
        array_walk($items, fn(Spot $item) => $this->add($item));
    }

    public function add(Spot $spot): self
    {
        $this->items[$spot->getUuid()->getValue()] = $spot;

        return $this;
    }

    public static function generateEmpty(int $size = 10): self
    {
        return new self(
            items: array_map(static fn() => new Spot(Uuid::create(), SpotState::makeFree()), range(1, $size))
        );
    }

    public function getFreeSpots(): SpotCollection
    {
        return new self(array_filter($this->items, static fn(Spot $item) => $item->getState()->isFree()));
    }

    public function count(): int
    {
        return count($this->items);
    }

    #[Pure] public function getFirstFree(): ?Spot
    {
        foreach ($this->items as $item) {
            if ($item->getState()->isFree()) {
                return $item;
            }
        }
        return null;
    }
}
