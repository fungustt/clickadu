<?php
namespace Catalog;

interface FilePathsExtractorInterface
{
    public function getFilePaths(string $dir): \Generator;
}