<?php
namespace File;

class FileIterator implements FileIteratorInterface
{
    /**
     * @param string $filePath
     *
     * @return \Generator
     */
    public function getDataGenerator(string $filePath): \Generator
    {
        $handle = fopen($filePath, "r");

        while(!feof($handle)) {
            yield fgetcsv($handle, 10000, "; ");
        }

        fclose($handle);
    }
}