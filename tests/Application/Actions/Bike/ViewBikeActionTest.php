<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Bike;

use App\Application\Actions\ActionError;
use App\Application\Actions\ActionPayload;
use App\Application\Handlers\HttpErrorHandler;
use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeNotFoundException;
use App\Infrastructure\Persistence\Bike\BikeRepository;
use DI\Container;
use Slim\Middleware\ErrorMiddleware;
use Tests\TestCase;

/**
 * Class ViewBikeActionTest
 *
 * @package Tests\Application\Actions\Bike
 */
class ViewBikeActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $bike = new Bike(1, 'bike de trilha', 'Caloi', 1000, new \DateTime(), 'João', 'Ciclista');

        $bikeRepositoryProphecy = $this->prophesize(BikeRepository::class);
        $bikeRepositoryProphecy
            ->findBikeById(1)
            ->willReturn($bike)
            ->shouldBeCalledOnce();

        $container->set(BikeRepository::class, $bikeRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/bikes/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $bike);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsUserNotFoundException()
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false ,false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        $bikeRepositoryProphecy = $this->prophesize(BikeRepository::class);
        $bikeRepositoryProphecy
            ->findBikeById(1)
            ->willThrow(new BikeNotFoundException())
            ->shouldBeCalledOnce();

        $container->set(BikeRepository::class, $bikeRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/bikes/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'The bike you requested does not exist.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
