<?php

namespace App\Interview\Parking\Domain\Exception;

use Exception;

class NotEnoughFreeSpots extends Exception
{
    protected $code = 400;
}
