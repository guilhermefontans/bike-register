<?php

namespace App\Application\Actions\Bike;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

/**
 * Class DeleteBikeAction
 *
 * @package App\Application\Actions\Bike
 */
class DeleteBikeAction extends BikeAction
{

    /**
     * @return Response
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        $bikeId = (int) $this->resolveArg('id');
        $this->bikeRepository->deleteBike($bikeId);

        $this->logger->info("Bike of id `${bikeId}` was deleted.");
        return $this->respondWithData(null, 204);
    }
}