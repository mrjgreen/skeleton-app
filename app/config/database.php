<?php
return array(
    'default' => 'mysql',

    'connections' => array(
        'mysql' => array(
            'lazy'      => true,
            'host'      => 'localhost',
            'username'  => 'root',
            'password'  => 'password',
            'database'  => 'test',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'driver'    => 'mysql',
            'options' => array(
                PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
            )
        )
    )
);
