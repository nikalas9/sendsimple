<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests/codeception');

$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'scriptUrl' => $params['baseUrl'],
        ],
        'log' => [
            'flushInterval' => 1,
            'targets' => [
                /*[
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],*/
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error','warning'],
                    'logVars' => [],
                    'logTable' => 'log_alert',
                    'exportInterval' => 1,
                ],
            ],
        ],
    ],
    'aliases' => [
        '@core' => '@app/components/core',
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
