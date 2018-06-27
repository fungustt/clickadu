<?php
namespace Test\File;

use File\CSVFile;
use PHPUnit\Framework\TestCase;

class CSVFileTest extends TestCase
{
    public function testConstructor()
    {
        $file = new CSVFile('someFilePath.csv');
        $this->assertEquals('someFilePath.csv', $file->getFilePath());
    }
}