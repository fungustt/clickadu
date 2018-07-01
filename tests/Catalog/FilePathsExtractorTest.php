<?php
namespace Test\Catalog;

use Catalog\FilePathsExtractor;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use org\bovigo\vfs\vfsStreamWrapper;
use PHPUnit\Framework\TestCase;

class FilePathsExtractorTest extends TestCase
{

    public function setUp()
    {
        vfsStreamWrapper::register();
        $root = vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));
        vfsStreamWrapper::getRoot()->addChild(new vfsStreamDirectory('subDir'));
        $child = vfsStreamWrapper::getRoot()->getChild('subDir');

        $root->addChild(new vfsStreamFile('file1.csv'));
        $child->addChild(new vfsStreamFile('file2.csv'));
    }

    public function testGetFilePaths()
    {
        $extractor = new FilePathsExtractor();

        $arrayToTest = [];
        foreach($extractor->getFilePaths(vfsStream::url('rootDir')) as $file) {
            $arrayToTest []= $file;
        }
        $this->assertEquals(
            [
                'vfs://rootDir/file1.csv',
                'vfs://rootDir/subDir/file2.csv',
            ],
            array_reverse($arrayToTest)
        );
    }
}