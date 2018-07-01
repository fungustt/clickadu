<?php
namespace File;

interface FileIteratorInterface
{
    /**
     * @param string $filePath
     *
     * @return \Generator
     */
    public function getDataGenerator(string $filePath): \Generator;
}