<?php
namespace Configurator;

use Aggregator\DataAggregator;
use Catalog\CatalogChecker;
use Catalog\DirectoryRemover;
use Catalog\FileLister;
use Catalog\FilePathsExtractor;
use Catalog\TmpDirManager;
use Catalog\Validator\CSVValidator;
use File\FileIterator;
use File\FileSorter;
use File\Manager\ResultFileManager;
use Handler\File\CSVHandler;
use Handler\FileListHandler;
use Log\Logger;

class Configurator
{
    public static function prepareApp(Config $config)
    {
        $catalogChecker = new CatalogChecker($config->getFileDir(), $config->getAppDir());
        if (!$catalogChecker->check()) {
            throw new \Exception('Specified catalog not found');
        }
        $filePath = $catalogChecker->getFullPath();
        $tmpPath = $catalogChecker->getTmpPath();

        $logger = new Logger();

        $fileLister = new FileLister(
            new FilePathsExtractor(),
            new CSVValidator()
        );

        $tmpDirManager = new TmpDirManager($tmpPath);

        $csvHandler = new CSVHandler(new FileIterator());

        $fileListHandler = new FileListHandler(
            $tmpDirManager,
            new FileSorter(),
            $config->getFilesToConcatCount(),
            $csvHandler
        );

        $resultFileManager = new ResultFileManager($config->getAppDir());
        $directoryRemover = new DirectoryRemover();

        $aggregator = new DataAggregator(
            $filePath,
            $fileLister,
            $fileListHandler,
            $directoryRemover,
            $resultFileManager
        );
        $aggregator->setLogger($logger);

        $app = new \App(
            $aggregator,
            $tmpDirManager
        );
        $app->setLogger($logger);

        return $app;
    }
}