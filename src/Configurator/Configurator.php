<?php
namespace Configurator;

use Query\Connection\MySQLConnection;
use Query\QueryBuilder;

class Configurator
{
    public static function prepareApp(Config $config)
    {
        $connection = new MySQLConnection(
            $config->getDbHost(),
            $config->getDbName(),
            $config->getDbUser(),
            $config->getDbPass()
        );

        $queryBuilder = QueryBuilder::getInstance();
        $queryBuilder->setConnection($connection);
    }
}