<?php
namespace Catalog;

class TmpDirManager implements TmpDirManagerInterface
{
    const DIR_NAME = 'step';
    /**
     * @var string
     */
    private $tmpDir;

    /**
     * StepDirManager constructor.
     *
     * @param string $tmpDir
     */
    public function __construct($tmpDir)
    {
        $this->tmpDir = $tmpDir;
    }

    /**
     * @param int $step
     *
     * @return string
     *
     * @throws \Exception
     */
    public function createTmpSubDirForStep(int $step)
    {
        $path = $this->tmpDir . '/' . self::DIR_NAME . $step;
        $created = mkdir($path);
        if (!$created) {
            throw new \Exception(sprintf('Dir for %s step can not be created', $step));
        }

        return $path;
    }

    public function clearTmpDir()
    {
        $iterator = new \RecursiveDirectoryIterator($this->tmpDir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } elseif ($file->getFilename() !== '.gitkeep') {
                unlink($file->getRealPath());
            }
        }
    }
}