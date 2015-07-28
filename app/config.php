<?php
return [
    'app.debug' => true,

    'router.cache' => false,

    'view.cache' => false,

    'session.name' => 's_id',

    'database.default' => 'mysql',

    'database.connections' => [
        'mysql' => [
            'host'      => 'localhost',
            'username'  => 'root',
            'password'  => 'password',
            'database'  => 'test',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'driver'    => 'mysql',
            'options' => [
                PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
            ]
        ]
    ]
];
