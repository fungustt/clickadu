<?php
namespace Query;

use Query\Connection\ConnectionInterface;

class QueryBuilder
{
    private static $instance = null;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @return QueryBuilder
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param ConnectionInterface $connection
     *
     * @throws \Exception
     */
    public function setConnection(ConnectionInterface $connection)
    {
        if (null !== $this->connection) {
            throw new \Exception('Connection was already set.');
        }

        $this->connection = $connection;
    }

    public function query(string $sql)
    {
        if (null === $this->connection) {
            throw new \Exception('Connection was not set');
        }

        return $this->connection->query($sql);
    }

    public function queryAll(string $sql)
    {
        if (null === $this->connection) {
            throw new \Exception('Connection was not set');
        }

        return $this->connection->queryAll($sql);
    }

    public function execute(string $sql)
    {
        if (null === $this->connection) {
            throw new \Exception('Connection was not set');
        }

        $this->connection->execute($sql);
    }

    private function __construct() {}

    private function __wakeup() {}

    private function __sleep() {}

    private function __clone() {}
}