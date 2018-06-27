<?php
namespace Query;

class DataSeeder
{
    const DATA_TABLE = 'data';
    const AGGREGATION_TABLE = 'aggregation';

    public static function prepareTables()
    {
        $qb = QueryBuilder::getInstance();

        foreach([self::DATA_TABLE, self::AGGREGATION_TABLE] as $table) {
            $sql = sprintf('DELETE FROM `%s`;', $table);

            $qb->execute($sql);
        }
    }

    public static function seedDataTable(string $filePath)
    {
        $sql = sprintf(
            'LOAD DATA LOCAL INFILE \'%s\' INTO TABLE %s FIELDS TERMINATED BY \'; \' LINES TERMINATED BY \'\r\n\' IGNORE 1 LINES (date, a, b, c)',
            $filePath,
            self::DATA_TABLE
        );

        $qb = QueryBuilder::getInstance();
        $qb->execute($sql);
    }

    public static function aggregateData()
    {
        $sql = sprintf(
            'INSERT %s SELECT * FROM %s ON DUPLICATE KEY UPDATE %s.a = %s.a + values(a), %s.b = %s.b + values(b), %s.c = %s.c + values(c)',
            self::AGGREGATION_TABLE,
            self::DATA_TABLE,
            self::AGGREGATION_TABLE,
            self::DATA_TABLE,
            self::AGGREGATION_TABLE,
            self::DATA_TABLE,
            self::AGGREGATION_TABLE,
            self::DATA_TABLE
        );

        $qb = QueryBuilder::getInstance();
        $qb->execute($sql);
    }
}