<?php

namespace App\Application\Actions\Bike;

use App\Application\Actions\Action;
use App\Domain\Validator\ValidatorInterface;
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
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * BikeAction constructor.
     *
     * @param LoggerInterface $logger
     * @param ValidatorInterface $validator
     * @param BikeRepository $bikeRepository
     */
    public function __construct(
        LoggerInterface $logger,
        ValidatorInterface $validator,
        BikeRepository $bikeRepository
    ) {
        parent::__construct($logger);
        $this->validator = $validator;
        $this->bikeRepository = $bikeRepository;
    }
}