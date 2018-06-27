<?php
namespace Handler\File;

use File\FileInterface;

interface HandlerInterface
{
    public function supports(FileInterface $file): bool;
    public function handle(FileInterface $file);
}