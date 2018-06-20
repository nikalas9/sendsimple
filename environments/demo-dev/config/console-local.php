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
        ],
    ]
];

return $config;