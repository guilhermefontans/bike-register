<?php

namespace Tests\Application\Actions\Bike;

use App\Application\Actions\ActionPayload;
use App\Infrastructure\Persistence\Bike\BikeRepository;
use DI\Container;
use Tests\TestCase;

/**
 * Class DeleteBikeActionTest
 *
 * @package Tests\Application\Actions\Bike
 */
class DeleteBikeActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $bikeRepositoryProphecy = $this->prophesize(BikeRepository::class);
        $bikeRepositoryProphecy
            ->deleteBike(1)
            ->shouldBeCalledOnce();

        $container->set(BikeRepository::class, $bikeRepositoryProphecy->reveal());

        $request = $this->createRequest('DELETE', '/bikes/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(204);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}