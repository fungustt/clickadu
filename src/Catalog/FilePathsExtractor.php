<?php
namespace Catalog;

class FilePathsExtractor implements FilePathsExtractorInterface
{
    public function getFilePaths(string $dir, int $level = -1): \Generator
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        if ($level > -1) {
            $iterator->setMaxDepth($level);
        }

        foreach ($iterator as $path => $obj) {
            if ($obj->isFile()) {
                yield $path;
            }
        }
    }
}