<?php
namespace Catalog;

interface DirectoryRemoverInterface
{
    /**
     * @param string $dirPath
     */
    public function remove(string $dirPath);
}