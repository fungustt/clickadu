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
        $catalogChecker = new CatalogChecker('existDir', vfsStream::url('rootDir'));
        $this->assertEquals(vfsStream::url('rootDir') . '/existDir', $catalogChecker->getFullPath());
    }

    public function testCheck()
    {
        $catalogChecker = new CatalogChecker(null, vfsStream::url('rootDir'));

        $this->expectException(\Exception::class);
        $catalogChecker->check();

        $catalogChecker = new CatalogChecker('existDir', vfsStream::url('rootDir'));
        $this->assertTrue($catalogChecker->check());
    }
}