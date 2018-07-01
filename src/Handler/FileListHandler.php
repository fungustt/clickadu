<?php
namespace Handler;

use Catalog\TmpDirManagerInterface;
use File\FileSorterInterface;
use Handler\File\HandlerInterface;

class FileListHandler implements FileListHandlerInterface
{
    const HEADER_STRING = 'date; A; B; C';

    /**
     * @var HandlerInterface[]
     */
    private $handlers;

    /**
     * @var TmpDirManagerInterface
     */
    private $tmpDirManager;

    /**
     * @var FileSorterInterface
     */
    private $fileSorter;

    /**
     * @var int
     */
    private $filesToConcatCount;

    /**
     * @var string
     */
    protected $tmpDir;

    /**
     * @var int
     */
    protected $fileIndex;

    protected $tmpFileHandle = null;

    /**
     * FileListHandler constructor.
     *
     * @param TmpDirManagerInterface $tmpDirManager
     * @param FileSorterInterface $fileSorter
     * @param int $filesToConcatCount
     * @param HandlerInterface[] $handlers
     */
    public function __construct(
        TmpDirManagerInterface $tmpDirManager,
        FileSorterInterface $fileSorter,
        int $filesToConcatCount,
        HandlerInterface ...$handlers
    ) {
        $this->tmpDirManager = $tmpDirManager;
        $this->fileSorter = $fileSorter;
        $this->filesToConcatCount = $filesToConcatCount;
        $this->handlers = $handlers;
    }


    /**
     * @param int $step
     * @param \Generator $files
     */
    public function handleList(int $step, \Generator $files)
    {
        $this->fileIndex = 1;
        $this->tmpDir = $this->tmpDirManager->createTmpSubDirForStep($step);
        $this->nextFileHandle();

        $fileIteration = 0;
        $emptyHandle = true;

        foreach($files as $file) {
            foreach($this->handlers as $handler) {
                if ($handler->supports($file)) {
                    if ($fileIteration >= $this->filesToConcatCount) {
                        $this->freeCurrentFileHandle();
                        $this->fileSorter->sortAndUnlink($this->getCurrentFilePath());
                        $this->fileIndex++;

                        $this->nextFileHandle();
                        $emptyHandle = true;

                        $fileIteration = 0;
                    } else {
                        $fileIteration++;
                        $emptyHandle = false;
                    }

                    $handler->aggregateToHandle($file, $this->tmpFileHandle);
                }
            }
        }

        if (!$emptyHandle) {
            $this->freeCurrentFileHandle();
            $this->fileSorter->sortAndUnlink($this->getCurrentFilePath());
        }
    }

    /**
     * @return bool
     */
    public function isFullyAggregated(): bool
    {
        return 1 === $this->fileIndex;
    }

    /**
     * @return string
     */
    public function getNextStepPath(): string
    {
        return $this->tmpDir;
    }

    /**
     * @return string
     */
    private function getCurrentFilePath(): string
    {
        return $this->tmpDir . '/file' . $this->fileIndex . '.csv';
    }

    private function nextFileHandle(): void
    {
        $this->tmpFileHandle = fopen($this->getCurrentFilePath(), 'a+');
        fwrite($this->tmpFileHandle, self::HEADER_STRING . "\r\n");
    }

    private function freeCurrentFileHandle(): void
    {
        fclose($this->tmpFileHandle);
    }
}