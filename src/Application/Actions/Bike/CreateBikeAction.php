<?php


namespace App\Application\Actions\Bike;


use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Factory\EntityInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class CreateBikeAction extends BikeAction
{

    /**
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        $data = $this->getFormData();

        /** @var EntityInterface $bike */
        $bike = $this->bikeRepository->createBike($data);

        $this->logger->info("Bike of id {$bike->getId()} was created.");
        return $this->respondWithData($bike);
    }
}