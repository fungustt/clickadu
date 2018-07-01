<?php
namespace File;

interface FileSorterInterface
{
    /**
     * @param string $inputFilePath
     */
    public function sortAndUnlink(string $inputFilePath);
}