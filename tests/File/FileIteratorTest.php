<?php
namespace Test\File;

use File\FileIterator;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use org\bovigo\vfs\vfsStreamWrapper;
use PHPUnit\Framework\TestCase;

class FileIteratorTest extends TestCase
{
    public function testCheckFIleIteration()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));

        $root = vfsStreamWrapper::getRoot();
        $root->addChild(new vfsStreamFile('file.csv'));

        $file = $root->getChild('file.csv');
        $file->setContent("1\r\n2\r\n3\r\n4");

        $fileIterator = new FileIterator(vfsStream::url('rootDir/file.csv'));
        $i = 1;
        foreach($fileIterator->getDataCollection() as $data) {
            $this->assertEquals($i, $data);
            $i++;
        }
    }
}