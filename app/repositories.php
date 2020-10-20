<?php
declare(strict_types=1);

use App\Infrastructure\Persistence\Bike\BikeRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        BikeRepository::class => \DI\autowire(App\Infrastructure\Persistence\Bike\BikeRepository::class),
    ]);
};
