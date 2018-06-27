<?php
require_once __DIR__ . '/vendor/autoload.php';

use Cli\CliArgumentInterpreter;
use Configurator\Configurator;
use Configurator\ConfigBuilder;

try {

    $configArguments = CliArgumentInterpreter::getConfigArguments($argv);
    $config = ConfigBuilder::build($configArguments);
    Configurator::prepareApp($config);

    (new App($config->getFileDir(), __DIR__))->run();

} catch (Exception $e) {
    die($e->getMessage());
}