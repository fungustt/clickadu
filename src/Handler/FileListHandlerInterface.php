<?php
namespace Handler;

interface FileListHandlerInterface
{
    /**
     * @param int $step
     * @param \Generator $files
     */
    public function handleList(int $step, \Generator $files);

    /**
     * @return bool
     */
    public function isFullyAggregated(): bool;

    /**
     * @return string
     */
    public function getNextStepPath(): string;
}