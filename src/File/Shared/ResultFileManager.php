<?php
namespace File\Shared;

use DTO\Data;
use Query\DataSeeder;
use Query\QueryBuilder;

class ResultFileManager extends AbstractFileManager
{
    const BATCH_SIZE = 10000;
    const HEADER_STRING = 'date; A; B; C';

    protected static $fileName = 'result.csv';

    public function fillDataFromDatabase()
    {
        $sql = sprintf("SELECT count(date) as count FROM %s", DataSeeder::AGGREGATION_TABLE);

        $qb = QueryBuilder::getInstance();
        $queryResult = $qb->query($sql);
        $count = $queryResult["count"];

        $iterations = ceil($count / self::BATCH_SIZE);

        for ($i = 0; $i < $iterations; $i++) {
            $sql = sprintf("SELECT `date`, `a`, `b`, `c` FROM %s ORDER BY `date` LIMIT %d, %d",
                DataSeeder::AGGREGATION_TABLE,
                self::BATCH_SIZE * $i,
                self::BATCH_SIZE
            );

            $queryResult = $qb->queryAll($sql);

            foreach($queryResult as $item) {
                $this->saveToFile(
                    new Data(
                        $item['date'],
                        $item['a'],
                        $item['b'],
                        $item['c']
                    )
                );
            }

            unset($queryResult);
        }
    }

    public function prepareFile()
    {
        parent::prepareFile();

        file_put_contents($this->filePath, sprintf("%s\r\n", self::HEADER_STRING));
    }

    public function saveToFile(Data $data)
    {
        if (!is_file($this->filePath)) {
            throw new \Exception('Result file was not created');
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

        unset($data);
    }
}