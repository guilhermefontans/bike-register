<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Factory\FactoryInterface;
use Doctrine\Common\Cache\Cache;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

abstract class AbstractRepository
{
    protected const DEFAULT_LIFE_TIME_CACHE = 60;
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var Cache
     */
    protected $cacheProvider;

    /**
     * AbstractRepository constructor.
     *
     * @param Connection $connection
     * @param LoggerInterface $logger
     * @param FactoryInterface $factory
     * @param Cache $cacheProvider
     */
    public function __construct(
        Connection $connection,
        LoggerInterface $logger,
        FactoryInterface $factory,
        Cache $cacheProvider
    ) {
        $this->connection = $connection;
        $this->logger = $logger;
        $this->factory = $factory;
        $this->cacheProvider = $cacheProvider;
    }
}