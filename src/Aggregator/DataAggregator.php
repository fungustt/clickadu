<?php
namespace Aggregator;

use Catalog\DirectoryRemoverInterface;
use Catalog\FileListerInterface;
use File\Manager\ResultFileManagerInterface;
use Handler\FileListHandlerInterface;
use Log\LoggerAwareTrait;

class DataAggregator implements DataAggregatorInterface
{
    use LoggerAwareTrait;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var FileListerInterface
     */
    private $fileLister;

    /**
     * @var FileListHandlerInterface
     */
    private $fileListHandler;

    /**
     * @var DirectoryRemoverInterface
     */
    private $directoryRemover;

    /**
     * @var ResultFileManagerInterface
     */
    private $resultFileManager;

    /**
     * @var int
     */
    protected $step = 1;

    /**
     * DataAggregator constructor.
     *
     * @param string $filePath
     * @param FileListerInterface $fileLister
     * @param FileListHandlerInterface $fileListHandler
     * @param DirectoryRemoverInterface $directoryRemover
     * @param ResultFileManagerInterface $resultFileManager
     */
    public function __construct(
        string $filePath,
        FileListerInterface $fileLister,
        FileListHandlerInterface $fileListHandler,
        DirectoryRemoverInterface $directoryRemover,
        ResultFileManagerInterface $resultFileManager
    ) {
        $this->filePath = $filePath;
        $this->fileLister = $fileLister;
        $this->fileListHandler = $fileListHandler;
        $this->directoryRemover = $directoryRemover;
        $this->resultFileManager = $resultFileManager;
    }

    /**
     * @param bool $break
     */
    public function aggregate(bool $break = false)
    {
        $files = $this->fileLister->getFileList($this->filePath);

        $this->fileListHandler->handleList($this->step, $files);

        if ($this->step > 1) {
            $this->directoryRemover->remove($this->filePath);
        }

        $this->filePath = $this->fileListHandler->getNextStepPath();

        $this->logger->log(sprintf('Step %s complete', $this->step));

        $this->step++;

        if (true === $break) {
            $this->resultFileManager->createFromTmpFile($this->filePath . '/file1_sorted.csv');
            return;
        }

        $this->aggregate($this->fileListHandler->isFullyAggregated());
    }
}