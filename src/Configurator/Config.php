<?php
namespace Configurator;

class Config
{
    /**
     * @var string
     */
    private $fileDir;

    /**
     * @var string
     */
    private $dbHost = "localhost";

    /**
     * @var string
     */
    private $dbName;

    /**
     * @var null|string
     */
    private $dbUser;

    /**
     * @var null|string
     */
    private $dbPass;

    /**
     * @return string
     */
    public function getFileDir(): string
    {
        return $this->fileDir;
    }

    /**
     * @param string $fileDir
     */
    public function setFileDir(string $fileDir)
    {
        $this->fileDir = $fileDir;
    }

    /**
     * @return string
     */
    public function getDbHost(): string
    {
        return $this->dbHost;
    }

    /**
     * @param string $dbHost
     */
    public function setDbHost(string $dbHost)
    {
        $this->dbHost = $dbHost;
    }

    /**
     * @return string
     */
    public function getDbName(): string
    {
        return $this->dbName;
    }

    /**
     * @param string $dbName
     */
    public function setDbName(string $dbName)
    {
        $this->dbName = $dbName;
    }

    /**
     * @return null|string
     */
    public function getDbUser(): ?string
    {
        return $this->dbUser;
    }

    /**
     * @param null|string $dbUser
     */
    public function setDbUser(?string $dbUser)
    {
        $this->dbUser = $dbUser;
    }

    /**
     * @return null|string
     */
    public function getDbPass(): ?string
    {
        return $this->dbPass;
    }

    /**
     * @param null|string $dbPass
     */
    public function setDbPass(?string $dbPass)
    {
        $this->dbPass = $dbPass;
    }
}