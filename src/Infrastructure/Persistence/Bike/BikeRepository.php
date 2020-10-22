<?php

namespace App\Infrastructure\Persistence\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeNotFoundException;
use App\Domain\Factory\Bike\BikeFactory;
use App\Domain\Factory\EntityInterface;
use App\Infrastructure\Persistence\AbstractRepository;
use Doctrine\Common\Cache\Cache;
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
     * @param Cache $cacheProvider
     */
    public function __construct(Connection $connection, LoggerInterface $logger, BikeFactory $factory, Cache $cacheProvider)
    {
        parent::__construct($connection, $logger, $factory, $cacheProvider);
    }

    /**
     * @return Bike[]
     */
    public function findAll(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $rows = $queryBuilder
            ->select('*')
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
    public function findBikeById(int $id): Bike
    {
        $key = 'bike_' . $id;
        if ($this->cacheProvider->contains($key)) {
            $this->logger->info("Getting Bike id #{$id} from cache");
            return $this->cacheProvider->fetch($key);
        }

        $this->cacheProvider->save('cache_id', 'my_data');
        $queryBuilder = $this->connection->createQueryBuilder();

        $row = $queryBuilder
            ->select('*')
            ->from('bikes')
            ->where('id = :id')
            ->setParameter(':id', $id)
            ->execute()
            ->fetch();

        if (!$row) {
            throw new BikeNotFoundException();
        }

        $entity = $this->factory->build($row);

        $this->logger->info("Getting Bike id #{$id} from data base");
        $this->cacheProvider->save($key, $entity, self::DEFAULT_LIFE_TIME_CACHE);

        return $entity;
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

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->insert('bikes')
            ->values([
                'description'   => ':description',
                'model'         => ':model',
                'price'         => ':price',
                'purchase_date' => ':purchase_date',
                'buyer_name'    => ':buyer_name',
                'store_name'    => ':store_name'
            ])
            ->setParameters([
                'description'   => $data['descricao'],
                'model'         => $data['modelo'],
                'price'         => $data['preco'],
                'purchase_date' => $data['data-compra'],
                'buyer_name'    =>  $data['nome-comprador'],
                'store_name'    => $data['nome-loja']
            ]);

        $this->logger->info('This SQL will be executed to create the bike {sql}', [
            'sql' => $queryBuilder->getSQL()
        ]);
        $queryBuilder->execute();
        $lastId = $this->connection->lastInsertId();

        return $this->factory->build(array_merge(['id' => $lastId], $values));
    }


    /**
     * @param int $id
     * @throws \Doctrine\DBAL\Exception
     */
    public function deleteBike(int $id): void
    {
        $this->connection->delete('bikes', ['id' => $id]);
        $this->logger->info("This Bike Id #{id} was excluded", [
            'id' => $id
        ]);
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

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->update('bikes')
            ->set('description', ':description')
            ->set('model', ':model')
            ->set('model', ':model')
            ->set('price', ':price')
            ->set('purchase_date', ':purchase_date')
            ->set('buyer_name', ':buyer_name')
            ->set('store_name',':store_name')
            ->setParameters([
                'description'   => $data['descricao'],
                'model'         => $data['modelo'],
                'price'         => $data['preco'],
                'purchase_date' => $data['data-compra'],
                'buyer_name'    =>  $data['nome-comprador'],
                'store_name'    => $data['nome-loja']
            ])->where("id={$id}")
            ->execute();
        return $this->factory->build(array_merge(['id' => $id], $values));
    }

    public function patchBike(int $id, array $data)
    {
        $values = [
            'description'   => isset($data['descricao']) ? $data['descricao'] : null,
            'model'         => isset($data['modelo']) ? $data['modelo'] : null,
            'price'         => isset($data['preco']) ? $data['preco'] : null,
            'purchase_date' => isset($data['data-compra']) ? $data['data-compra']: null,
            'buyer_name'    => isset($data['nome-comprador']) ? $data['nome-comprador'] : null,
            'store_name'    => isset($data['nome-loja']) ? $data['nome-loja']: null
        ];

        $values = array_filter($values, function ($item) {
            return !is_null($item);
        });

        $this->connection->update('bikes', $values, ['id' => $id]);
    }
}