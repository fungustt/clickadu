<?php
namespace Catalog\Validator;

use File\CSVFile;
use File\FileInterface;

class CSVValidator implements ValidatorInterface
{
    public function validate(string $filePath): bool
    {
        if (preg_match('/\.csv$/i', $filePath)) {
            return true;
        }

        return false;
    }

    public function getFile(string $filePath): FileInterface
    {
        return new CSVFile($filePath);
    }
}