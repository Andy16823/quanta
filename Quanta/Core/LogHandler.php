<?php
namespace Quanta\Core;
use Quanta\Quanta;

class LogHandler
{
    const LEVEL_INFO = 'INFO';
    const LEVEL_WARNING = 'WARNING';
    const LEVEL_ERROR = 'ERROR';
    const LEVEL_DEBUG = 'DEBUG';
    const LEVEL_CRITICAL = 'CRITICAL';

    public function log($level, $message, $logfile)
    {
        file_put_contents($logfile, "[" . date('Y-m-d H:i:s') . "] [$level] $message" . PHP_EOL, FILE_APPEND);
    }

    public function info($message, $logfile)
    {
        $this->log(self::LEVEL_INFO, $message, $logfile);
    }

    public function warning($message, $logfile)
    {
        $this->log(self::LEVEL_WARNING, $message, $logfile);
    }

    public function error($message, $logfile)
    {
        $this->log(self::LEVEL_ERROR, $message, $logfile);
    }
    
    public function debug($message, $logfile)
    {
        $this->log(self::LEVEL_DEBUG, $message, $logfile);
    }

    public function critical($message, $logfile)
    {
        $this->log(self::LEVEL_CRITICAL, $message, $logfile);
    }
}