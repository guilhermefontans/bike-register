<?php


namespace App\Application\Actions\Bike;

use App\Domain\Factory\EntityInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

/**
 * Class CreateBikeAction
 *
 * @package App\Application\Actions\Bike
 */
class CreateBikeAction extends BikeAction
{
    /**
     * @return Response
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        $data = $this->getFormData();
        $this->validator->validate($data);

        /** @var EntityInterface $bike */
        $bike = $this->bikeRepository->createBike($data);

        $this->logger->info("Bike of id {$bike->getId()} was created.");
        return $this->respondWithData($bike, 201);
    }
}