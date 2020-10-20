<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Factory\FactoryInterface;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

abstract class AbstractRepository
{
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
     * AbstractRepository constructor.
     *
     * @param Connection $connection
     * @param LoggerInterface $logger
     * @param FactoryInterface $factory
     */
    public function __construct(Connection $connection, LoggerInterface $logger, FactoryInterface $factory)
    {
        $this->connection = $connection;
        $this->logger = $logger;
        $this->factory = $factory;
    }

}