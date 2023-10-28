<?php

namespace App\Handler;

use App\DbConnection;
use Psr\Container\ContainerInterface;

class DBConnectionFactory
{
    public function __invoke(ContainerInterface $container): DbConnection
    {
        /**
         * @var ContainerInterface
         * Достаем конфиг подключения к БД
         */

        $config = $container->get('config')['database'];
        return new DbConnection($config);
    }
}
