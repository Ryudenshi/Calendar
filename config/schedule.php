<?php

use App\Console\Commands\SendEventStartRm;

return [
    'default' => env('QUEUE_CONNECTION', 'database'),

    'schedule' => [
        SendEventStartRm::class,
    ],
];
