<?php
namespace Configurator;

use Exception;
use Query\Connection\ConnectionInterface;

class ConfigBuilder
{
    public static function build(array $arguments): Config
    {
        $config = new Config();

        if (!isset($arguments['-dir'])) {
            throw new Exception('File dir not specified. Please use key -dir=path_to_dir');
        }
        $config->setFileDir($arguments['-dir']);

        $config->setDbHost($arguments['-h'] ?? ConnectionInterface::LOCALHOST);

        if (!isset($arguments['-n'])) {
            throw new Exception('Database name not specified. Please use key -n=basename');
        }
        $config->setDbName($arguments['-n']);

        $config->setDbUser($arguments['-u'] ?? null);

        $config->setDbPass($arguments['-p'] ?? null);

        return $config;
    }
}