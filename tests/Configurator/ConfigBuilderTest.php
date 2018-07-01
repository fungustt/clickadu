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
        ConfigBuilder::build([], 'appDir');
    }

    public function testConfigBuilderThrowOnWrongCount()
    {
        $this->expectException(\Exception::class);
        ConfigBuilder::build(['-c' => 'teststring'], 'appDir');
    }

    public function testConfigBuilderBuilds()
    {
        $config = new Config();
        $config->setFileDir('somedir');
        $config->setFilesToConcatCount(2);
        $config->setAppDir('appDir');

        $this->assertEquals($config, ConfigBuilder::build(['-dir' => 'somedir'], 'appDir'));
    }
}