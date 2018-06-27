<?php
use \Catalog\FileLister;
use \Handler\FileListHandler;
use \File\Shared\SharedFileManager;
use \File\Shared\ResultFileManager;
use \Query\DataSeeder;
use Log\Logger;

class App
{
    /**
     * @var null|string
     */
    private $fileDir;

    /**
     * @var string
     */
    private $appDir;

    public function __construct(?string $fileDir, string $appDir)
    {
        $this->fileDir = $fileDir;
        $this->appDir = $appDir;
    }

    public function run()
    {
        $fileLister = new FileLister($this->appDir);
        $files = $fileLister->getFileListFromDir($this->fileDir);

        if (!count($files)) {
            throw new Exception('Data files not found in specified catalog');
        }

        Logger::log("Catalog tree scaned. List of found files:");
        foreach ($files as $file) {
            Logger::log('- ' . $file->getFilePath());
        }
        Logger::log("Starting data consuming\r\n");

        $sharedFileManager = new SharedFileManager($this->appDir);
        $sharedFileManager->prepareFile();

        $handler = new FileListHandler($sharedFileManager);
        $handler->handleList($files);

        Logger::log("Data consuming finished. Starting data aggregation\r\n");

        DataSeeder::prepareTables();
        DataSeeder::seedDataTable($sharedFileManager->getFilePath());
        DataSeeder::aggregateData();

        Logger::log("Data aggregation finished. Starting filling result.csv with aggregated data\r\n");

        $resultFileManager = new ResultFileManager($this->appDir);
        $resultFileManager->prepareFile();
        $resultFileManager->fillDataFromDatabase();

        Logger::log("Done. Result aggregated data saved in result.csv");
        Logger::log("Exiting");
    }
}