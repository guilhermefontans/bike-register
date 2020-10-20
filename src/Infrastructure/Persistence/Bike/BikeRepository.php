<?php

namespace App\Infrastructure\Persistence\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeNotFoundException;

/**
 * Class BikeRepository
 *
 * @package App\Infrastructure\Persistence\Bike
 */
class BikeRepository implements \App\Domain\Bike\BikeRepository
{

    /**
     * @return Bike[]
     */
    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @param int $id
     * @return Bike
     * @throws BikeNotFoundException
     */
    public function findUserOfId(int $id): Bike
    {
        // TODO: Implement findUserOfId() method.
    }
}