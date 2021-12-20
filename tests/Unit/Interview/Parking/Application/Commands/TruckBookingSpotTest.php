<?php

namespace Interview\Parking\Application\Commands;

use App\Interview\Parking\Application\Commands\CarBookingSpot;
use App\Interview\Parking\Application\Commands\TruckBookingSpot;
use App\Interview\Parking\Application\Dto\BookingSpotDto;
use App\Interview\Parking\Domain\Contracts\ParkingRepository;
use App\Interview\Parking\Domain\Entities\FloorCollection;
use App\Interview\Parking\Domain\Entities\Parking;
use App\Interview\Parking\Domain\ValueObjects\Uuid;
use Mockery\MockInterface;
use Tests\TestCase;

class TruckBookingSpotTest extends TestCase
{
    public function test_it_books_spots_for_trucks(): void
    {
        $uuid = Uuid::create();
        $parking = new Parking(
            uuid: $uuid,
            floors: FloorCollection::generateEmpty(2) // 20 places, but only 5 for trucks (it takes 2 places, and can't use second floor)
        );

        $this->mock(ParkingRepository::class, function (MockInterface $mock) use ($parking, $uuid) {
            $mock->shouldReceive('get')->with($uuid)->andReturn($parking);
        });

        /** @var CarBookingSpot $carBookingCommand */
        $carBookingCommand = app(TruckBookingSpot::class);


        $fiveTimes = range(1, 5); // 5 places on the first floor
        array_walk($fiveTimes, function () use ($uuid, $carBookingCommand) {
            $result = $carBookingCommand->handle(new BookingSpotDto($uuid));
            $this->assertTrue($result);
        });

        $result = $carBookingCommand->handle(new BookingSpotDto($uuid));
        self::assertFalse($result);
    }
}
