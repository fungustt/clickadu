<?php
namespace Test\Catalog;

use Catalog\TmpDirManager;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;
use PHPUnit\Framework\TestCase;

class TmpDirManagerTest extends TestCase
{
    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('tmpDir'));
        vfsStreamWrapper::getRoot()->addChild(new vfsStreamDirectory('subDir'));
    }

    public function testCreateTmpSubDirForStep()
    {
        $tmpDirManager = new TmpDirManager(vfsStream::url('tmpDir'));
        $tmpDirManager->createTmpSubDirForStep(1);

        $this->assertNotNull(vfsStreamWrapper::getRoot()->getChild('step1'));
        $this->assertNull(vfsStreamWrapper::getRoot()->getChild('step2'));
    }
}