<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'database' => [
            'mysql' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'slim_eloquent',
                'username' => 'admin',
                'password' => 'GataXux@1',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_0900_ai_ci',
                'prefix' => '',
            ],
            'sqlite' => [
                'driver'   => 'sqlite',
                'database' => __DIR__.'/../db.sqlite',
                'foreign_key_constraints' => true,
                'prefix'   => '',
            ],
        ],
    ],
];
