<?php
namespace Query\Connection;

interface ConnectionInterface
{
    const LOCALHOST = 'localhost';

    public function execute(string $query);

    public function query(string $query);

    public function queryAll(string $query);
}