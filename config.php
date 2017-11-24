<?php

return [

    'debug' => true, // this is so that doctrine generates proxy classes each request, needs fixing

    'site-dir' => __DIR__,

    'plugins' => [
        'database' => [
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'db.sqlite'
        ]
    ]

];