<?php

return [
    'default' => 'mysql', // default connection

    'connections' => [
        'mainEnv' => [
            'driver'    => 'mysql',
            'host'      => $_ENV['DB_HOST'],
            'database'  => $_ENV['DB_NAME'],
            'username'  => $_ENV['DB_USER'],
            'password'  => $_ENV['DB_PASS'],
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ],
        /*        
        'pgsql' => [
            'driver'   => 'pgsql',
            'host'     => '127.0.0.1',
            'database' => 'dbname',
            'username' => 'username',
            'password' => 'password',
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],
        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => __DIR__ . '/database.sqlite',
            'prefix'   => '',
        ],
        */
    ],
];
