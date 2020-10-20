<?php


namespace App\Application\Actions\Bike;


use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

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
        return $this->respondWithData($bikes);
    }
}