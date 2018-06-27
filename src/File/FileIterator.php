<?php
namespace File;

class FileIterator
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * FileIterator constructor.
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }


    public function getDataCollection()
    {
        $handle = fopen($this->filePath, "r");

        while(!feof($handle)) {
            yield trim(fgets($handle));
        }

        fclose($handle);
    }
}