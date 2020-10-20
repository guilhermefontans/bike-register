<?php


namespace App\Application\Actions\Bike;


use Psr\Http\Message\ResponseInterface as Response;

class ViewBikeAction extends BikeAction
{
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user = $this->bikeRepository->findUserOfId($userId);

        $this->logger->info("User of id `${userId}` was viewed.");

        return $this->respondWithData($user);
    }
}