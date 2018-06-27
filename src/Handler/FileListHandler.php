<?php
namespace Handler;

use File\FileInterface;
use File\Shared\SharedFileManager;
use Handler\File\CSVHandler;
use Handler\File\HandlerInterface;

class FileListHandler
{
    /**
     * @var HandlerInterface
     */
    private $handlers;

    /**
     * FileListHandler constructor.
     *
     * @param SharedFileManager $fileManager
     */
    public function __construct(SharedFileManager $fileManager)
    {
        $this->handlers = [
            new CSVHandler($fileManager),
        ];
    }

    /**
     * @param FileInterface[] $files
     */
    public function handleList(array $files)
    {
        foreach($files as $file) {
            $this->handle($file);
        }
    }

    private function handle(FileInterface $file)
    {
        foreach($this->handlers as $handler) {
            if ($handler->supports($file)) {
                $handler->handle($file);
                return;
            }
        }
    }
}