<?php
namespace Catalog;

interface TmpDirManagerInterface
{
    /**
     * @param int $step
     *
     * @return string
     *
     * @throws \Exception
     */
    public function createTmpSubDirForStep(int $step);

    public function clearTmpDir();
}