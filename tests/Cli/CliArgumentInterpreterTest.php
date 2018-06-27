<?php
namespace Test\Cli;

use Cli\CliArgumentInterpreter;
use PHPUnit\Framework\TestCase;

class CliArgumentInterpreterTest extends TestCase
{
    public function testGetConfigArguments()
    {
        $inputArray = [
            '-h',
            '-d=123',
            'qwerty',
            '-n=localhost'
        ];

        $outputArray = [
            '-d' => '123',
            '-n' => 'localhost'
        ];

        $this->assertEquals(
            $outputArray,
            CliArgumentInterpreter::getConfigArguments($inputArray)
        );
    }
}