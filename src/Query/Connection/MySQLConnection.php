<?php
namespace Query\Connection;

use PDO;

class MySQLConnection implements ConnectionInterface
{
    private $connection;

    /**
     * MySQLConnection constructor.
     *
     * @param string $host
     * @param string $dbName
     * @param null|string $username
     * @param null|string $password
     */
    public function __construct(
        string $host,
        string $dbName,
        ?string $username,
        ?string $password
    ) {
        $this->connection = new PDO(
            sprintf(
                'mysql:host=%s;dbname=%s',
                $host,
                $dbName
            ),
            $username,
            $password,
            [
                PDO::MYSQL_ATTR_LOCAL_INFILE => true
            ]
        );
    }

    public function execute(string $query)
    {
        $this->connection->exec($query);
    }

    public function query(string $query)
    {
        $statement = $this->connection->query($query);

        if ($statement) {
            /**
             * @var \PDOStatement
             */
            return $statement->fetch();
        }

        return null;
    }

    public function queryAll(string $query)
    {
        $statement = $this->connection->query($query);

        if ($statement) {
            /**
             * @var \PDOStatement
             */
            return $statement->fetchAll();
        }

        return null;
    }
}