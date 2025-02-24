<?php

namespace Src\Core;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class Logging {
    static function debug(string $message, ?array $context = []):void {
        $self = new Logging();
        $self->_writeLog('app', Level::Debug, fn($logger) => $logger->debug($message, $context));
    }

    // -----------
    // Privates

    private function _writeLog(string $channel, Level $logType, callable $call):void {
        $rootDirectory = Defs::getRootDirectory();
        $logger = new Logger($channel);
        $localTime = BaseObject::pyNow();
        if (!file_exists($rootDirectory.'/Logs')) {
            mkdir($rootDirectory.'/Logs', 0777, true);
        }
        $fileName = $rootDirectory.'/Logs/app-'.$localTime->format('Y-m-d').'.log';
        $logger->pushHandler(new StreamHandler($fileName, $logType));
        $call($logger);
    }
}