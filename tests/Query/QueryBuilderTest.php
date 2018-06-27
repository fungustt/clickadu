<?php
namespace Test\Query;

use PHPUnit\Framework\TestCase;
use Query\Connection\MySQLConnection;
use Query\QueryBuilder;

class QueryBuilderTest extends TestCase
{
    public function testIsSingleton() {
        $this->assertEquals(QueryBuilder::getInstance(), QueryBuilder::getInstance());
    }

    public function testQueryWillThrowErrorWithoutConnection()
    {
        $this->clearQueryBuilder();
        $this->expectException(\Exception::class);
        QueryBuilder::getInstance()->query("");
    }

    public function testQueryAllWillThrowErrorWithoutConnection()
    {
        $this->clearQueryBuilder();
        $this->expectException(\Exception::class);
        QueryBuilder::getInstance()->queryAll("");
    }

    public function testExecuteWillThrowErrorWithoutConnection()
    {
        $this->clearQueryBuilder();
        $this->expectException(\Exception::class);
        QueryBuilder::getInstance()->execute("");
    }

    public function testConnectionCanNotBeSetTwice()
    {
        $this->clearQueryBuilder();
        $mysqlConnectionMock = $this->createMock(MySQLConnection::class);
        QueryBuilder::getInstance()->setConnection($mysqlConnectionMock);
        $this->expectException(\Exception::class);
        QueryBuilder::getInstance()->setConnection($mysqlConnectionMock);
    }

    private function clearQueryBuilder()
    {
        $singleton = QueryBuilder::getInstance();
        $reflection = new \ReflectionClass($singleton);
        $instance = $reflection->getProperty('instance');
        $instance->setAccessible(true);
        $instance->setValue(null, null);
        $instance->setAccessible(false);
    }
}