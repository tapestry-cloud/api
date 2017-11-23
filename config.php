<?php

return [

    'site-dir' => __DIR__,

    'plugins' => [
        'database' => [
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'db.sqlite'
        ]
    ]

];