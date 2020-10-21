<?php


namespace App\Application\Actions\Bike;


use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class PatchBikeAction extends BikeAction
{

    /**
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    protected function action(): Response
    {
        $bikeId = (int) $this->resolveArg('id');
        $data = $this->getFormData();
        $this->bikeRepository->patchBike($bikeId, $data);

        $this->logger->info("Bike of id `${bikeId}` was patched.");
        return $this->respondWithData(null, 204);
    }
}