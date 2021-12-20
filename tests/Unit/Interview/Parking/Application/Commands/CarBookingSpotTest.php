<?php

namespace Interview\Parking\Application\Commands;

use App\Interview\Parking\Applications\Commands\CarBookingSpot;
use App\Interview\Parking\Applications\Dto\BookingSpotDto;
use App\Interview\Parking\Domain\Contracts\ParkingRepository;
use App\Interview\Parking\Domain\Entities\FloorCollection;
use App\Interview\Parking\Domain\Entities\Parking;
use App\Interview\Parking\Domain\ValueObjects\Uuid;
use Mockery\MockInterface;
use Tests\TestCase;

class CarBookingSpotTest extends TestCase
{
    /**
     * @throws \App\Interview\Parking\Domain\Exception\ParkingNotFound
     */
    public function test_it_books_the_spot_when_there_is_enough_free_spots(): void
    {
        $uuid = Uuid::create();
        $parking = new Parking(
            uuid: $uuid,
            floors: FloorCollection::generateEmpty(2)
        );

        $this->mock(ParkingRepository::class, function (MockInterface $mock) use ($parking, $uuid) {
            $mock->shouldReceive('get')->with($uuid)->andReturn($parking);
        });

        /** @var CarBookingSpot $carBookingCommand */
        $carBookingCommand = app(CarBookingSpot::class);

        $result = $carBookingCommand->handle(new BookingSpotDto($uuid));

        self::assertTrue($result);
    }

    /**
     * @throws \App\Interview\Parking\Domain\Exception\ParkingNotFound
     */
    public function test_it_does_not_book_the_spot_when_there_is_not_enough_free_spots(): void
    {
        $uuid = Uuid::create();
        $parking = new Parking(
            uuid: $uuid,
            floors: FloorCollection::generateEmpty(2)
        );

        $this->mock(ParkingRepository::class, function (MockInterface $mock) use ($parking, $uuid) {
            $mock->shouldReceive('get')->with($uuid)->andReturn($parking);
        });

        /** @var CarBookingSpot $carBookingCommand */
        $carBookingCommand = app(CarBookingSpot::class);

        $tenTimes = range(1, 20); // two floors
        array_walk($tenTimes, function () use ($uuid, $carBookingCommand) {
            $result = $carBookingCommand->handle(new BookingSpotDto($uuid));
            $this->assertTrue($result);
        });

        $result = $carBookingCommand->handle(new BookingSpotDto($uuid));
        self::assertFalse($result);
    }
}
