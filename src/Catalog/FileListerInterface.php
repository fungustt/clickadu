<?php
namespace Catalog;

interface FileListerInterface
{
    /**
     * @param null|string $fileDir
     *
     * @return \Generator
     *
     * @throws \Exception
     */
    public function getFileList(string $fileDir): \Generator;
}