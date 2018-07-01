<?php
namespace Test\Catalog;

use Catalog\FilePathsExtractor;
use Catalog\Validator\CSVValidator;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use \Catalog\FileLister;
use \org\bovigo\vfs\vfsStreamWrapper;
use \org\bovigo\vfs\vfsStreamDirectory;
use \org\bovigo\vfs\vfsStreamFile;

class FileListerTest extends TestCase
{
    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));
        vfsStreamWrapper::getRoot()->addChild(new vfsStreamDirectory('subDir'));
    }


    public function testGetFileListFromDirWillReturnJustOneRightFile()
    {
        vfsStreamWrapper::getRoot()->addChild(new vfsStreamDirectory('subDir'));
        $catalog = vfsStreamWrapper::getRoot()->getChild('subDir');
        $catalog->addChild(new vfsStreamFile('file.csv'));
        $catalog->addChild(new vfsStreamFile('file.xml'));


        $extractor = new FilePathsExtractor();
        $lister = new FileLister($extractor, new CSVValidator());
        $this->assertCount(1, $lister->getFileList(vfsStream::url('rootDir/subDir')));
    }
}