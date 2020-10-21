<?php

namespace App\Application\Actions\Bike;

use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

/**
 * Class ListBikesAction
 * @package App\Application\Actions\Bike
 */
class ListBikesAction extends BikeAction
{

    /**
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        $bikes = $this->bikeRepository->findAll();
        $total = count($bikes);

        $this->logger->info("Listing {$total} bikes.");
        return $this->respondWithData($bikes);
    }
}