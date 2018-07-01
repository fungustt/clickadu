<?php
namespace Handler\File;

use File\FileIteratorInterface;
use Validator\DateValidator;
use DTO\Data;
use File\CSVFile;
use File\FileInterface;

class CSVHandler implements HandlerInterface
{
    /**
     * @var FileIteratorInterface
     */
    private $fileIterator;

    /**
     * CSVHandler constructor.
     *
     * @param FileIteratorInterface $fileIterator
     */
    public function __construct(FileIteratorInterface $fileIterator)
    {
        $this->fileIterator = $fileIterator;
    }

    public function supports(FileInterface $file): bool
    {
        if ($file instanceof CSVFile) {
            return true;
        }

        return false;
    }

    public function aggregateToHandle(FileInterface $file, $handle)
    {
        $currentDto = null;
        foreach($this->fileIterator->getDataGenerator($file->getFilePath()) as $dataArray) {
            if (!$dataArray) {
                continue;
            }

            $dataDto = $this->getData($dataArray);

            if (null === $currentDto) {
                $currentDto = $dataDto;
            } elseif (null !== $currentDto && $currentDto->getDate() === $dataDto->getDate()) {
                /**
                 * @var Data $currentDto
                 */
                $currentDto = new Data(
                    $currentDto->getDate(),
                    $currentDto->getA() + $dataDto->getA(),
                    $currentDto->getB() + $dataDto->getB(),
                    $currentDto->getC() + $dataDto->getC()
                );
            } else {
                $this->saveDataToHandle($currentDto, $handle);
                $currentDto = $dataDto;
            }
        }
    }

    private function getData(array $dataArray): ?Data
    {
        if (!DateValidator::validate($dataArray[0])) {
            return null;
        }

        if (!is_numeric($dataArray[1])
            || !is_numeric($dataArray[2])
            || !is_numeric($dataArray[3])
        ) {
            return null;
        }

        return new Data(...$dataArray);
    }

    private function saveDataToHandle(Data $data, $handle)
    {
        fwrite(
            $handle,
            sprintf("%s; %s; %s; %s\r\n",
                $data->getDate(),
                $data->getA(),
                $data->getB(),
                $data->getC()
            )
        );
    }
}