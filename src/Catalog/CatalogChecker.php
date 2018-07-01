<?php
namespace Catalog;

class CatalogChecker
{
    const TMP_DIR = 'tmp';

    /**
     * @var string
     */
    private $fileDir = null;

    /**
     * @var string
     */
    private $appDir;

    /**
     * CatalogChecker constructor.
     * @param string $fileDir
     * @param string $appDir
     */
    public function __construct($fileDir, $appDir)
    {
        $this->fileDir = $fileDir;
        $this->appDir = $appDir;
    }


    public function check(): bool
    {
        if (!$this->fileDir) {
            throw new \Exception('Catalog not specified. Script usage example: php run.php -d=/var/www/files');
        }

        $path = $this->getFullPath();

        if (is_dir($path)) {
            return true;
        }

        return false;
    }

    public function getFullPath(): string
    {
        if (preg_match("/^..\//", $this->fileDir)) {
            return $this->appDir . '/' . $this->fileDir;
        }

        if (preg_match("/^.\//", $this->fileDir)) {
            return $this->appDir . substr($this->fileDir, 1, mb_strlen($this->fileDir) - 1);
        }

        if (preg_match("/^\//", $this->fileDir)) {
            return $this->fileDir;
        }

        return $this->appDir . '/' . $this->fileDir;
    }

    public function getTmpPath(): string
    {
        return $this->appDir . '/' . self::TMP_DIR;
    }
}