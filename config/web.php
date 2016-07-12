<?php

$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'app-sender',
    'basePath' => dirname(__DIR__),

    'bootstrap' => ['log'],

    'name'=>'Admin SendSimple',

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'WncLmQ4U6VDuT0vFL_zx04UKd8g7L12B',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        /*'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],*/
        'user' => [
            'class' => 'amnah\yii2\user\components\User',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'assetManager' => [
            'assetMap' => [
                //'jquery.js' => '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
                'jquery.ui.js'=>false,
            ],
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => [
                        '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => 'app',
                    'css' => [
                        'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => 'app',
                    'js'=>[
                        'js/bootstrap/bootstrap.min.js',
                    ]
                ],
                /*'yii\grid\GridViewAsset' => [
                    'sourcePath' => '@core/components/assets',
                    'js'=>[
                        'yii.gridView.js',
                    ]
                ],*/
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@vendor/amnah/yii2-user/views' => '@app/views/user', // example: @app/views/user/default/login.php
                ],
            ],
        ],
        'formatter' => [
            'datetimeFormat' => 'php:d/m/Y H:i',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            'controllerMap' => [
                'default' => 'app\controllers\user\DefaultController',
                'admin' => 'app\controllers\user\AdminController',
            ],
            'useEmail'=>true,
            'requireEmail'=>false,
            'emailConfirmation'=>false,
            'emailChangeConfirmation'=>false,
            'requireUsername'=>true,

            'modelClasses'  => [
                'User' => 'app\models\User', // note: don't forget component user::identityClass above
            ],
            //'emailViewPath' => '@app/mail/user', // example: @app/mail/user/confirmEmail.php*/
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'root' => [
                'baseUrl'=>'http://sender/public',
                'basePath'=>'public',
                'path'=>'',
            ],
        ]
    ],
    'aliases' => [
        '@core' => '@app/components/core',
        '@core/components/formWidgets' => '@app/components/core/form-widgets',
        '@core/components/gridColumns' => '@app/components/core/grid-columns',
        '@core/components/gridBulkActions' => '@app/components/core/grid-bulk-actions',
        '@core/components/gridPageSize' => '@app/components/core/grid-page-size',
    ],
    'params' => $params,
];

return $config;
