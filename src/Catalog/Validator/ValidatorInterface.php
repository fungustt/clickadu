<?php
namespace Catalog\Validator;

use File\FileInterface;

interface ValidatorInterface
{
    public function validate(string $filePath): bool;

    public function getFile(string $filePath): FileInterface;
}