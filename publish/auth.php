<?php

return [
    'default' => 'admin',
    'driver' => TokenDriver::class,

    'modules' => [
        'admin' => [
            'model' => '', // App\Model\User:class
        ]
    ]
];