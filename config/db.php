<?php

/*return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=sender',
    'username' => 'root',
    'password' => '1',
    'charset' => 'utf8',
    'tablePrefix' => 'tbl_'
];*/

return [
    'class'    => 'yii\db\Connection',
    'dsn'      => 'pgsql:host=localhost;port=5432;dbname=sender',
    'username' => 'postgres',
    'password' => 'hgnk2310',
    'charset'  => 'utf8',
    'tablePrefix' => 'tbl_',
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 3600,
    //'schemaCache' => 'cache',
];
