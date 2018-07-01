<?php
namespace Log;

interface LoggerInterface
{
    /**
     * @param string $message
     */
    public function log(string $message);
}