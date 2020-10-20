<?php

namespace App\Domain\Factory;

interface FactoryInterface
{

    /**
     * Must return a entity interface
     *
     * @param array $data
     * @return EntityInterface
     */
    public function build(array $data): EntityInterface;
}