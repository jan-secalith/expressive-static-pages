<?php

return [
    'db' => [
        'adapters' => [
            'Application\Db\LocalAdapter' => [
                'driver' => 'Pdo_Mysql',
                'dsn'    => 'mysql:dbname=%%DB_SCHEMA%%;host=%%DB_HOST%%;',
                'username' => '%%DB_USERNAME%%',
                'password' => '%%DB_PASSWORD%%'
            ]
        ],
    ],
];