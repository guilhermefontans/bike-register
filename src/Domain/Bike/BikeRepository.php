<?php


namespace App\Domain\Bike;


interface BikeRepository
{

    /**
     * @return Bike[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Bike
     * @throws BikeNotFoundException
     */
    public function findBikeById(int $id): Bike;
}