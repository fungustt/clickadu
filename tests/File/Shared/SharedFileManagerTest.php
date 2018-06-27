<?php
namespace Test\File\Shared;

use DTO\Data;
use File\Shared\SharedFileManager;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;
use PHPUnit\Framework\TestCase;

class SharedFileManagerTest extends TestCase
{
    public function testPrepareFile()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));

        $fileManager = new SharedFileManager(vfsStream::url('rootDir'));
        $fileManager->prepareFile();

        $dir = vfsStreamWrapper::getRoot();

        $this->assertTrue(true ,$dir->hasChild('tmp.csv'));

        $file = $dir->getChild('tmp.csv');
        $this->assertEquals(SharedFileManager::HEADER_STRING . "\r\n", $file->getContent());
    }

    public function testGetFilePath()
    {
        $fileManager = new SharedFileManager('/var/www');
        $this->assertEquals('/var/www/tmp.csv', $fileManager->getFilePath());
    }

    public function testSaveToFile()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));

        $fileManager = new SharedFileManager(vfsStream::url('rootDir'));
        $fileManager->prepareFile();

        $dir = vfsStreamWrapper::getRoot();
        $file = $dir->getChild('tmp.csv');

        $fileManager->saveToFile(new Data('2015-01-01', 1, 2, 3));
        $this->assertEquals(SharedFileManager::HEADER_STRING . "\r\n2015-01-01; 1; 2; 3\r\n", $file->getContent());
    }
}