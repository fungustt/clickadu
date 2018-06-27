<?php
namespace Test\Catalog;

use PHPUnit\Framework\TestCase;
use \Catalog\FileLister;
use \org\bovigo\vfs\vfsStreamWrapper;
use \org\bovigo\vfs\vfsStreamDirectory;
use \org\bovigo\vfs\vfsStream;
use \org\bovigo\vfs\vfsStreamFile;

class FileListerTest extends TestCase
{
    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));
        vfsStreamWrapper::getRoot()->addChild(new vfsStreamDirectory('subDir'));
    }

    public function testGetFileListFromDirThrowsException()
    {
        $lister = new FileLister(vfsStream::url('rootDir'));

        $this->expectException(\Exception::class);
        $lister->getFileListFromDir('somedir');
    }

    public function testGetFileListFromDir()
    {
        $lister = new FileLister(vfsStream::url('rootDir'));
        $this->assertEquals([], $lister->getFileListFromDir('subDir'));
    }

    public function testGetFileListFromDirWillReturnJustOneRightFile()
    {
        vfsStreamWrapper::getRoot()->addChild(new vfsStreamDirectory('subDir'));
        $catalog = vfsStreamWrapper::getRoot()->getChild('subDir');
        $catalog->addChild(new vfsStreamFile('file.csv'));
        $catalog->addChild(new vfsStreamFile('file.xml'));

        $lister = new FileLister(vfsStream::url('rootDir'));
        $this->assertCount(1, $lister->getFileListFromDir('subDir'));
    }
}