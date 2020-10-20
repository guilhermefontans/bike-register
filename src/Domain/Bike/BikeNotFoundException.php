<?php


namespace App\Domain\Bike;

use App\Domain\DomainException\DomainRecordNotFoundException;

class BikeNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The bike you requested does not exist.';
}