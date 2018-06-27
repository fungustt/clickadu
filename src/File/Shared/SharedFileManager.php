<?php
namespace File\Shared;

use DTO\Data;
use Log\Logger;

class SharedFileManager extends AbstractFileManager
{
    const HEADER_STRING = 'date; A; B; C';

    protected static $fileName = 'tmp.csv';

    /**
     * @param Data $data
     *
     * @throws \Exception
     */
    public function saveToFile(Data $data)
    {
        if (!is_file($this->filePath)) {
            throw new \Exception('Shared file was not created');
        }

        file_put_contents(
            $this->filePath,
            sprintf(
                "%s; %s; %s; %s\r\n",
                $data->getDate(),
                $data->getA(),
                $data->getB(),
                $data->getC()
            ),
            FILE_APPEND
        );
    }

    public function prepareFile()
    {
        parent::prepareFile();

        Logger::log("Preparing intermediate csv file with data");

        file_put_contents($this->filePath, sprintf("%s\r\n", self::HEADER_STRING));

        Logger::log("Intermediate csv file prepared\r\n");
    }
}