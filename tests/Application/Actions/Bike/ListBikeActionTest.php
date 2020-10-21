<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Bike;

use App\Application\Actions\ActionPayload;
use App\Domain\Bike\BikeRepository;
use App\Domain\Bike\Bike;
use DI\Container;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\ResultStatement;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Statement;
use Tests\TestCase;

class ListBikeActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $bike = new Bike(1, 'bike de trilha', 'Caloi', 1000, new \DateTime(), 'João', 'Ciclista');

        $connection = $this->prophesize(Connection::class);
        $bikeRepositoryProphecy = $this->prophesize(BikeRepository::class);
        $queryBuilder = $this->prophesize(QueryBuilder::class);
        $statment = $this->prophesize(Statement::class);

        $connection->createQueryBuilder()->will([$queryBuilder, 'reveal']);
        $container->set(Connection::class, $connection->reveal());
        $container->set(BikeRepository::class, $bikeRepositoryProphecy->reveal());

        $queryBuilder->select(
            'id',
            'description',
            'model',
            'price',
            'purchase_date',
            'buyer_name',
            'store_name'
        )->will([$queryBuilder, 'reveal']);
        $queryBuilder->from('bikes')->will([$statment, 'reveal']);
        $statment->execute()->will([$statment, 'reveal']);
        $statment->fetchAll()->willReturn([$bike]);

        $request = $this->createRequest('GET', '/bikes');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$bike]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
