<?php
return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    [
        'components' => [
            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=yii2-mysql;dbname=yii2db_test',
                'username' => 'yii2user',
                'password' => 'yii2pass',
                'charset' => 'utf8',
            ],
        ],
    ]
);
