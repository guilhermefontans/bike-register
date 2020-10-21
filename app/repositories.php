<?php
declare(strict_types=1);

use App\Domain\Factory\Bike\BikeFactory;
use App\Domain\Validator\BikeValidator;
use App\Domain\Validator\ValidatorInterface;
use App\Infrastructure\Persistence\Bike\BikeRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        BikeRepository::class => \DI\autowire(App\Infrastructure\Persistence\Bike\BikeRepository::class),
        BikeFactory::class => \DI\autowire(App\Domain\Factory\Bike\BikeFactory::class),
        ValidatorInterface::class => \DI\autowire(BikeValidator::class),
    ]);
};
