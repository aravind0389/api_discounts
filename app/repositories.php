<?php
declare(strict_types=1);

use App\Domain\Discounts\DiscountsRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Persistence\Discounts\InMemoryDiscountsRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        DiscountsRepository::class => \DI\autowire(InMemoryDiscountsRepository::class),
    ]);
};
