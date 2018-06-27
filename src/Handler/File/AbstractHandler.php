<?php
namespace Handler\File;

use DTO\Data;
use File\FileInterface;
use File\Shared\SharedFileManager;

abstract class AbstractHandler implements HandlerInterface
{
    /**
     * @var SharedFileManager
     */
    private $sharedFileManager;

    /**
     * AbstractHandler constructor.
     *
     * @param SharedFileManager $sharedFileManager
     */
    public function __construct(SharedFileManager $sharedFileManager)
    {
        $this->sharedFileManager = $sharedFileManager;
    }

    abstract public function supports(FileInterface $file): bool;

    abstract public function handle(FileInterface $file);

    protected function saveDto(Data $data)
    {
        $this->sharedFileManager->saveToFile($data);
    }
}