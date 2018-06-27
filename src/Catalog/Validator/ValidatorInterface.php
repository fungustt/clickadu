<?php
namespace Catalog\Validator;

use File\FileInterface;

interface ValidatorInterface
{
    public static function validate(string $filePath): bool;

    public static function getFile(string $filePath): FileInterface;
}