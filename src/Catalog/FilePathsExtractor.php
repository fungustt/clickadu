<?php
namespace Catalog;

class FilePathsExtractor implements FilePathsExtractorInterface
{
    /**
     * @param string $dir
     *
     * @return string[]
     */
    public function getFilePaths(string $dir): array
    {
        $result = [];
        $files = scandir($dir);

        foreach ($files as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            if (is_dir($dir . '/' . $file)) {
                $result = array_merge($result, $this->getFilePaths($dir . '/' . $file));
            }

            if (is_file($dir . '/' . $file)) {
                $result []= $dir . '/' . $file;
            }
        }

        return $result;
    }
}