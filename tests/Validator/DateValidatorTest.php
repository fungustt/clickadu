<?php
namespace Test\Validator;

use PHPUnit\Framework\TestCase;
use Validator\DateValidator;

class DateValidatorTest extends TestCase
{
    public function testValidation()
    {
        $this->assertTrue(DateValidator::validate('2015-01-01'));
        $this->assertFalse(DateValidator::validate('01-01-01'));
    }
}