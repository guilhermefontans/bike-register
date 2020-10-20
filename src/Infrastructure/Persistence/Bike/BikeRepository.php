<?php

namespace App\Infrastructure\Persistence\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeNotFoundException;
use Doctrine\DBAL\Connection;

/**
 * Class BikeRepository
 *
 * @package App\Infrastructure\Persistence\Bike
 */
class BikeRepository implements \App\Domain\Bike\BikeRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * BikeRepository constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Bike[]
     */
    public function findAll(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $rows = $queryBuilder
            ->select('id', 'nome')
            ->from('bikes')
            ->execute()
            ->fetchAll();
        return $rows;
    }

    /**
     * @param int $id
     * @return Bike
     * @throws BikeNotFoundException
     */
    public function findUserById(int $id): Bike
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $row = $queryBuilder->select('id', 'name')
            ->from('bikes')
            ->where('id = :id')
            ->setParameter(':id', 1)
            ->execute()
            ->fetch();

        return new Bike($row['id'], $row['name']);
    }

    public function update(array $data)
    {
        $values = ['nome' => $data['nome']];
        $this->connection->update('bikes', $values, ['id' => 1]);
    }
}