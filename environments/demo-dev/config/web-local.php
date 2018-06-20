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
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
