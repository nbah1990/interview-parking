<?php

namespace App\Interview\Parking\Domain\Exception;

use Exception;

class ParkingNotFound extends Exception
{
    protected $code = 404;
}
