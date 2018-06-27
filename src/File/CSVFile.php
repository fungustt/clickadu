<?php
namespace File;

class CSVFile implements FileInterface
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * CSVFile constructor.
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }
}