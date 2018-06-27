<?php
namespace Test\File\Shared;

use File\Shared\ResultFileManager;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;
use PHPUnit\Framework\TestCase;
use Query\Connection\MySQLConnection;
use Query\QueryBuilder;

class ResultFileManagerTest extends TestCase
{
    public function testPrepareFile()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));

        $fileManager = new ResultFileManager(vfsStream::url('rootDir'));
        $fileManager->prepareFile();

        $dir = vfsStreamWrapper::getRoot();

        $this->assertTrue(true ,$dir->hasChild('result.csv'));

        $file = $dir->getChild('result.csv');
        $this->assertEquals(ResultFileManager::HEADER_STRING . "\r\n", $file->getContent());
    }

    public function testGetFilePath()
    {
        $fileManager = new ResultFileManager('/var/www');
        $this->assertEquals('/var/www/result.csv', $fileManager->getFilePath());
    }

    public function testFillDataFromDatabase()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));

        $fileManager = new ResultFileManager(vfsStream::url('rootDir'));
        $fileManager->prepareFile();

        $dir = vfsStreamWrapper::getRoot();
        $file = $dir->getChild('result.csv');

        $mysqlConnectionMock = $this->createMock(MySQLConnection::class);
        $mysqlConnectionMock->method('query')->willReturn(
            ['count' => 3]
        );
        $mysqlConnectionMock->method('queryAll')->willReturn(
            [
                [
                    'date' => '2015-01-01',
                    'a' => 1,
                    'b' => 2,
                    'c' => 3
                ],
                [
                    'date' => '2015-01-02',
                    'a' => 1,
                    'b' => 2,
                    'c' => 3
                ],
                [
                    'date' => '2015-01-03',
                    'a' => 1,
                    'b' => 2,
                    'c' => 3
                ]
            ]
        );

        $queryBuilder = QueryBuilder::getInstance();
        $queryBuilder->setConnection($mysqlConnectionMock);

        $fileManager->fillDataFromDatabase();

        $content = ResultFileManager::HEADER_STRING . "\r\n2015-01-01; 1; 2; 3\r\n2015-01-02; 1; 2; 3\r\n2015-01-03; 1; 2; 3\r\n";
        $this->assertEquals($content, $file->getContent());
    }
}