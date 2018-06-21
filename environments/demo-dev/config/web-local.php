<?php
$config = [
    'components' => [
        'db' => [
            'class'    => 'yii\db\Connection',
            'dsn'      => 'pgsql:host=localhost;port=5432;dbname=sender',
            'username' => 'root',
            'password' => '',
            'charset'  => 'utf8',
            'tablePrefix' => 'tbl_',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0
        ],
    ],
    'timeZone' => 'Europe/Kiev',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*']
    ];

    /*$config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];*/
}

return $config;
