<?php
namespace Test\Configurator;

use Configurator\Config;
use Configurator\ConfigBuilder;
use PHPUnit\Framework\TestCase;

class ConfigBuilderTest extends TestCase
{
    public function testConfigBuilderThrowOnEmptyDir()
    {
        $this->expectException(\Exception::class);
        ConfigBuilder::build(['-n' => 'basename']);
    }

    public function testConfigBuilderThrowOnEmptyHost()
    {
        $this->expectException(\Exception::class);
        ConfigBuilder::build(['-dir' => 'somedir']);
    }

    public function testConfigBuilderBuilds()
    {
        $config = new Config();
        $config->setFileDir('somedir');
        $config->setDbName('basename');

        $this->assertEquals($config, ConfigBuilder::build(['-n' => 'basename', '-dir' => 'somedir']));
    }
}