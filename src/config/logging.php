<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'daily'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'daily' => [
            'driver' => 'daily',
            'path'   => storage_path('logs/lumen/lumen.log'),
            'level'  => 'debug',
            'days'   => 14,
        ],

        'access' => [
            'driver' => 'daily',
            'path'   => storage_path('logs/access/access.log'),
            'level'  => 'debug',
        ],

        'errors' => [
            'driver' => 'daily',
            'path'   => storage_path('logs/errors/error.log'),
            'level'  => 'debug',
        ],
    ],
];
