<?php

namespace App\Domain\Factory\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Factory\EntityInterface;
use App\Domain\Factory\FactoryInterface;

/**
 * Class BikeFactory
 *
 * @package App\Domain\Factory\Bike
 */
class BikeFactory implements FactoryInterface
{
    /**
     * @param array $data
     * @return EntityInterface
     * @throws \Exception
     */
    public function build(array $data): EntityInterface
    {
        return new Bike(
            $data['id'] ?: null,
            $data['description'],
            $data['model'],
            $data['price'],
            new \DateTime($data['purchase_date']),
            $data['buyer_name'],
            $data['store_name']
        );
    }
}