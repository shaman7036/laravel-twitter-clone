<?php

namespace App\Loggers;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use App\Models\Log;

class LogsTableProcessingHandler extends AbstractProcessingHandler
{
    protected $table = 'logs';
    protected $connection = 'mysql';

    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    protected function write(array $record): void
    {
        $data = [
            'instance' => gethostname(),
            'message' => $record['message'],
            'channel' => $record['channel'],
            'level' => $record['level'],
            'level_name' => $record['level_name'],
            'context' => json_encode($record['context']),
            'remote_addr' => isset($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : null,
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
            'created_at' => $record['datetime']->format('Y-m-d H:i:s'),
        ];
        Log::insert($data);
    }
}
