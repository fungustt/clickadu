<?php
namespace Log;

class Logger implements LoggerInterface
{
    /**
     * @param string $message
     */
    public function log(string $message)
    {
        // Так как нет никаких требований к логам, будем просто выводить в консоль.
        echo "[" . date("H:i:s") . "] " . $message . "\r\n";
    }
}