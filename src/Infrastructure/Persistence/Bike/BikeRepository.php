<?php

namespace App\Infrastructure\Persistence\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeNotFoundException;
use App\Domain\Factory\Bike\BikeFactory;
use App\Domain\Factory\EntityInterface;
use App\Infrastructure\Persistence\AbstractRepository;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

/**
 * Class BikeRepository
 *
 * @package App\Infrastructure\Persistence\Bike
 */
class BikeRepository extends AbstractRepository implements \App\Domain\Bike\BikeRepository
{
    /**
     * BikeRepository constructor.
     *
     * @param Connection $connection
     * @param LoggerInterface $logger
     * @param BikeFactory $factory
     */
    public function __construct(Connection $connection, LoggerInterface $logger, BikeFactory $factory)
    {
        parent::__construct($connection, $logger, $factory);
    }

    /**
     * @return Bike[]
     */
    public function findAll(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $rows = $queryBuilder
            ->select(
                'id',
                'description',
                'model',
                'price',
                'purchase_date',
                'buyer_name',
                'store_name'
            )->from('bikes')
            ->execute()
            ->fetchAll();



        return $rows;
    }

    /**
     * @param int $id
     * @return Bike
     * @throws BikeNotFoundException
     */
    public function findBikeById(int $id): Bike
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $row = $queryBuilder
            ->select(
                'id',
                'description',
                'model',
                'price',
                'purchase_date',
                'buyer_name',
                'store_name'
            )->from('bikes')
            ->where('id = :id')
            ->setParameter(':id', $id)
            ->execute()
            ->fetch();

        if (!$row) {
            throw new BikeNotFoundException();
        }

        return $this->factory->build($row);
    }

    public function createBike(array $data): EntityInterface
    {
        $values = [
            'description'   => $data['descricao'],
            'model'         => $data['modelo'],
            'price'         => $data['preco'],
            'purchase_date' => $data['data-compra'],
            'buyer_name'    => $data['nome-comprador'],
            'store_name'    => $data['nome-loja']
        ];

        $this->connection->insert('bikes', $values);
        $lastId = $this->connection->lastInsertId();

        return $this->factory->build(array_merge(['id' => $lastId], $values));
    }

    public function deleteBike(int $id): void
    {
        $this->connection->delete('bikes', ['id' => $id]);
    }

    public function updateBikeById(int $id, array $data)
    {
        $values = [
            'description'   => $data['descricao'],
            'model'         => $data['modelo'],
            'price'         => $data['preco'],
            'purchase_date' => $data['data-compra'],
            'buyer_name'    => $data['nome-comprador'],
            'store_name'    => $data['nome-loja']
        ];

        $this->connection->update('bikes', $values, ['id' => $id]);
        return $this->factory->build(array_merge(['id' => $id], $values));
    }

    public function patchBike(int $id, array $data)
    {
        $values = [
            'description'   => $data['descricao'] ?: null,
            'model'         => $data['modelo'] ?: null,
            'price'         => $data['preco'] ?: null,
            'purchase_date' => $data['data-compra']?: null,
            'buyer_name'    => $data['nome-comprador'] ?: null,
            'store_name'    => $data['nome-loja'] ?: null
        ];

        $values = array_filter($values, function ($item) {
            return !is_null($item);
        });

        $this->connection->update('bikes', $values, ['id' => $id]);
    }
}