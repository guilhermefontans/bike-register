<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Bike;

use App\Application\Actions\ActionPayload;
use App\Domain\Bike\Bike;
use App\Infrastructure\Persistence\Bike\BikeRepository;
use DI\Container;
use Tests\TestCase;

/**
 * Class ListBikeActionTest
 *
 * @package Tests\Application\Actions\Bike
 */
class ListBikeActionTest extends TestCase
{
    public function testAction()
    {$app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $bike = new Bike(1, 'bike de trilha', 'Caloi', 1000, new \DateTime(), 'João', 'Ciclista');

        $bikeRepositoryProphecy = $this->prophesize(BikeRepository::class);
        $bikeRepositoryProphecy
            ->findAll()
            ->willReturn([$bike])
            ->shouldBeCalledOnce();

        $container->set(BikeRepository::class, $bikeRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/bikes');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$bike]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
