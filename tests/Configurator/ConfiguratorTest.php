<?php
namespace Test\Configurator;

use Configurator\ConfigBuilder;
use Configurator\Configurator;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;
use PHPUnit\Framework\TestCase;

class ConfiguratorTest extends TestCase
{
    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));
        vfsStreamWrapper::getRoot()->addChild(new vfsStreamDirectory('subDir'));
    }


    public function testAppCreates()
    {
        $config = ConfigBuilder::build(['-dir' => 'subDir'], vfsStream::url('rootDir'));
        $app = Configurator::prepareApp($config);

        $this->assertTrue($app instanceof \App);
    }
}