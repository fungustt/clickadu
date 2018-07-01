<?php
namespace Catalog;

class DirectoryRemover implements DirectoryRemoverInterface
{
    /**
     * @param string $dirPath
     */
    public function remove(string $dirPath)
    {
        $iterator = new \RecursiveDirectoryIterator($dirPath, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }

        rmdir($dirPath);
    }
}