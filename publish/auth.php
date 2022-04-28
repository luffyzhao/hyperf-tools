<?php

use LHyperfTools\Auth\Driver\TokenDriver;

return [
    'default' => 'admin',
    'driver' => TokenDriver::class,

    'modules' => [
        'admin' => [
            'model' => '', // App\Model\User:class
        ]
    ]
];