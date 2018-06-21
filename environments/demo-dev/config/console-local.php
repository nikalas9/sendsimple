<?php

$config = [
    'components' => [
        'db' => [
            'class'    => 'yii\db\Connection',
            'dsn'      => 'pgsql:host=localhost;port=5432;dbname=sender',
            'username' => 'root',
            'password' => '1',
            'charset'  => 'utf8',
            'tablePrefix' => 'tbl_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
            'keyPrefix' => 'mlrcache',
            'redis' => 'redis'
        ],
    ]
];

return $config;