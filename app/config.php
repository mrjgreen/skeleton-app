<?php
return [
    'app.debug' => true,

    'app.csrf_secret' => 't6=0er98jv1c7/ufb82hgva123r',

    'router.cache' => false,

    'view.cache' => false,

    'session.name' => 's_id',

    'auth.max_attempts' => 10,

    'auth.ban_period_minutes' => 10,

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
