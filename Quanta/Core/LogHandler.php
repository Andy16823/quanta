<?php
namespace Quanta\Core;
use Quanta\Quanta;

class LogHandler
{
    const LEVEL_INFO = 'INFO';
    const LEVEL_WARNING = 'WARNING';
    const LEVEL_ERROR = 'ERROR';

    public function log($level, $message, $logfile)
    {
        file_put_contents($logfile, "[" . date('Y-m-d H:i:s') . "] [$level] $message" . PHP_EOL, FILE_APPEND);
    }
}