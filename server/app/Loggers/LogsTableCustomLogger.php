<?php

namespace App\Loggers;

use Monolog\Logger;

class LogsTableCustomLogger
{
    public function __invoke(array $config)
    {
        $logger = new Logger("LogsTableProcessingHandler");
        return $logger->pushHandler(new LogsTableProcessingHandler());
    }
}
