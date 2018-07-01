<?php
namespace Configurator;

class Config
{
    /**
     * @var string
     */
    private $fileDir;

    /**
     * @var string
     */
    private $appDir;

    /**
     * @var int
     */
    private $filesToConcatCount;

    /**
     * @return string
     */
    public function getFileDir(): string
    {
        return $this->fileDir;
    }

    /**
     * @param string $fileDir
     */
    public function setFileDir(string $fileDir)
    {
        $this->fileDir = $fileDir;
    }

    /**
     * @return string
     */
    public function getAppDir(): string
    {
        return $this->appDir;
    }

    /**
     * @param string $appDir
     */
    public function setAppDir(string $appDir)
    {
        $this->appDir = $appDir;
    }

    /**
     * @return int
     */
    public function getFilesToConcatCount(): int
    {
        return $this->filesToConcatCount;
    }

    /**
     * @param int $filesToConcatCount
     */
    public function setFilesToConcatCount(int $filesToConcatCount)
    {
        $this->filesToConcatCount = $filesToConcatCount;
    }
}