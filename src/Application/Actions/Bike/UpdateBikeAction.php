<?php


namespace App\Application\Actions\Bike;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class UpdateBikeAction extends BikeAction
{

    /**
     * @return Response
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        $bikeId = (int) $this->resolveArg('id');
        $data = $this->getFormData();
        $bike = $this->bikeRepository->updateBikeById($bikeId, $data);

        $this->logger->info("Bike of id `${bikeId}` was updated.");
        return $this->respondWithData($bike);
    }
}