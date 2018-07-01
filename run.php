<?php
require_once __DIR__ . '/vendor/autoload.php';

use Cli\CliArgumentInterpreter;
use Configurator\Configurator;
use Configurator\ConfigBuilder;

try {
    $configArguments = CliArgumentInterpreter::getConfigArguments($argv);
    $config = ConfigBuilder::build($configArguments, __DIR__);
    $app = Configurator::prepareApp($config);
    $app->run();

} catch (Exception $e) {
    die($e->getMessage());
}