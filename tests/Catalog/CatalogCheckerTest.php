<?php
namespace Test\Catalog;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;
use PHPUnit\Framework\TestCase;
use Catalog\CatalogChecker;

class CatalogCheckerTest extends TestCase
{
    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));
        vfsStreamWrapper::getRoot()->addChild(new vfsStreamDirectory('existDir'));
    }

    public function testGetFullPath()
    {
        $this->assertEquals('/var/www/../somepath', CatalogChecker::getFullPath('../somepath', '/var/www'));
        $this->assertEquals('/var/www/somepath', CatalogChecker::getFullPath('./somepath', '/var/www'));
        $this->assertEquals('/somepath', CatalogChecker::getFullPath('/somepath', '/var/www'));
        $this->assertEquals('/var/www/somepath', CatalogChecker::getFullPath('somepath', '/var/www'));
    }

    public function testCheck()
    {
        $this->expectException(\Exception::class);
        CatalogChecker::check(null, 'someappdir');

        $this->assertTrue(CatalogChecker::check('existDir', vfsStream::url('rootDir')));
        $this->assertFalse(CatalogChecker::check('nonExistDir', vfsStream::url('rootDir')));
    }
}