<?php
namespace Test\Catalog\Validator;

use File\CSVFile;
use PHPUnit\Framework\TestCase;
use Catalog\Validator\CSVValidator;

class CSVValidatorTest extends TestCase
{
    public function testValidate()
    {
        $this->assertTrue(CSVValidator::validate('some.csv'));
        $this->assertFalse(CSVValidator::validate('notcsv.xml'));
        $this->assertFalse(CSVValidator::validate('hack.csv.exe'));
    }

    public function testGetFile()
    {
        $filePath = 'sometest.csv';
        $this->assertEquals(new CSVFile($filePath), CSVValidator::getFile($filePath));
    }
}