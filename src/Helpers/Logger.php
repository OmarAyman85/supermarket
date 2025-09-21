<?php

namespace SuperMarket\Helpers;

trait Logger {
    protected function logEvent(string $message){
        $logfile = __DIR__ . '/../../Storage/Logs/app.log';

        if (!file_exists($logfile)) {
                mkdir($logfile, 0777, true); 
                }
        
        date_default_timezone_set('Africa/Cairo');
        $date = date('Y-m-d H:i:s');

        $formattedMessage = "[$date] $message";

        file_put_contents($logfile, $formattedMessage . PHP_EOL, FILE_APPEND);
    }
}
?>