<?php
namespace File;

class FileSorter implements FileSorterInterface
{
    /**
     * @param string $inputFilePath
     */
    public function sortAndUnlink(string $inputFilePath)
    {
        $pathInfo = pathinfo($inputFilePath);

        shell_exec(
            sprintf(
                '(head -n 1 %s && tail -n +2 %s | sort) > %s',
                $inputFilePath,
                $inputFilePath,
                sprintf(
                    "%s/%s_sorted.%s",
                    $pathInfo['dirname'],
                    $pathInfo['filename'],
                    $pathInfo['extension']
                )
            )
        );

        unlink($inputFilePath);
    }
}