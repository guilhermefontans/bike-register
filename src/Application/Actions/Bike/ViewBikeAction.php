<?php


namespace App\Application\Actions\Bike;


use Psr\Http\Message\ResponseInterface as Response;

class ViewBikeAction extends BikeAction
{
    protected function action(): Response
    {
        $bikeId = (int) $this->resolveArg('id');
        $bike = $this->bikeRepository->findBikeById($bikeId);

        $this->logger->info("Bike of id `${bikeId}` was viewed.");
        return $this->respondWithData($bike);
    }
}