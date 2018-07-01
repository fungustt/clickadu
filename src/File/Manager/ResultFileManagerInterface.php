<?php
namespace File\Manager;

interface ResultFileManagerInterface
{
    /**
     * @param string $tmpFilePath
     */
    public function createFromTmpFile(string $tmpFilePath);
}