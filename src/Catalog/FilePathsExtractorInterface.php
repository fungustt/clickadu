<?php
namespace Catalog;

interface FilePathsExtractorInterface
{
    /**
     * @param string $dir
     *
     * @return string[]
     */
    public function getFilePaths(string $dir): array;
}