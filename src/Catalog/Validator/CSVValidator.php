<?php
namespace Catalog\Validator;

use File\CSVFile;
use File\FileInterface;

class CSVValidator implements ValidatorInterface
{
    public static function validate(string $filePath): bool
    {
        if (preg_match('/\.csv$/i', $filePath)) {
            return true;
        }

        return false;
    }

    public static function getFile(string $filePath): FileInterface
    {
        return new CSVFile($filePath);
    }
}