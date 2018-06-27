<?php
namespace File\Shared;

use DTO\Data;

abstract class AbstractFileManager
{
    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var null
     */
    protected static $fileName;

    /**
     * SharedFileManager constructor
     *
     * @param string $appPath
     */
    public function __construct(string $appPath)
    {
        $this->filePath = $appPath . '/' . static::$fileName;
    }

    public function prepareFile()
    {
        if (is_file($this->filePath)) {
            unlink($this->filePath);
        }

        file_put_contents($this->filePath, "");
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    abstract public function saveToFile(Data $data);
}