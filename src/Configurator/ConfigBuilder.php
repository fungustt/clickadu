<?php
namespace Configurator;

use Exception;
use Query\Connection\ConnectionInterface;

class ConfigBuilder
{
    public static function build(array $arguments, string $appDir): Config
    {
        $config = new Config();

        if (!isset($arguments['-dir'])) {
            throw new Exception('File dir not specified. Please use key -dir=path_to_dir');
        }
        $config->setFileDir($arguments['-dir']);

        if (isset($arguments['-c']) && !is_numeric($arguments['-c']) && !is_int($arguments['-c'])) {
            throw new Exception('Files concat count must be right integer');
        }
        $config->setFilesToConcatCount($arguments['-c'] < 2 ? 2 : $arguments['-c']);

        $config->setAppDir($appDir);

        return $config;
    }
}