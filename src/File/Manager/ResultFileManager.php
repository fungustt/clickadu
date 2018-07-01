<?php
namespace File\Manager;

class ResultFileManager implements ResultFileManagerInterface
{
    const FILENAME = 'result.csv';

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @param string $appDir
     */
    public function __construct(string $appDir)
    {
        $this->filePath = $appDir . '/' . self::FILENAME;
    }

    /**
     * @param string $tmpFilePath
     */
    public function createFromTmpFile(string $tmpFilePath)
    {
        if (is_file($this->filePath)) {
            unlink($this->filePath);
        }

        copy($tmpFilePath, $this->filePath);
    }
}