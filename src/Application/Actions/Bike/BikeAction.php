<?php

namespace App\Application\Actions\Bike;

use App\Application\Actions\Action;
use App\Infrastructure\Persistence\Bike\BikeRepository;
use Psr\Log\LoggerInterface;

/**
 * Class BikeAction
 *
 * @package App\Application\Actions\Bike
 */
abstract class BikeAction extends Action
{

    /**
     * @var BikeRepository
     */
    protected $bikeRepository;

    /**
     * BikeAction constructor.
     *
     * @param LoggerInterface $logger
     * @param BikeRepository $bikeRepository
     */
    public function __construct(LoggerInterface $logger, BikeRepository $bikeRepository)
    {
        parent::__construct($logger);
        $this->bikeRepository = $bikeRepository;
    }
}