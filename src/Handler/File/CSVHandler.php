<?php
namespace Handler\File;

use Log\Logger;
use Validator\DateValidator;
use DTO\Data;
use File\CSVFile;
use File\FileInterface;
use File\FileIterator;

class CSVHandler extends AbstractHandler implements HandlerInterface
{
    const DATA_VALIDATE_PATTERN = '/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}\; [+-]?([0-9]*[.])?[0-9]+\; [+-]?([0-9]*[.])?[0-9]+\; [+-]?([0-9]*[.])?[0-9]+$/';

    public function supports(FileInterface $file): bool
    {
        if ($file instanceof CSVFile) {
            return true;
        }

        return false;
    }

    public function handle(FileInterface $file)
    {
        $iterator = new FileIterator($file->getFilePath());

        Logger::log(sprintf("Started data consuming from file: %s", $file->getFilePath()));

        foreach($iterator->getDataCollection() as $dataRow) {
            $dataDto = $this->getData($dataRow);
            if (null !== $dataDto) {
                $this->saveDto($dataDto);
            } else {
                Logger::log(sprintf("Row: \"%s\" skipped, inappropriate data string", $dataRow));
            }
        }

        Logger::log(sprintf("Finished data consuming. Moving to next step\r\n"));
    }

    private function getData(string $dataRow): ?Data
    {
        if (!preg_match(self::DATA_VALIDATE_PATTERN, $dataRow)) {
            return null;
        }

        $dataArray = explode("; ", $dataRow);

        if (!DateValidator::validate($dataArray[0])) {
            return null;
        }

        return new Data(...$dataArray);
    }
}