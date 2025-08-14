<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=db;dbname=yii2db', // 'db' is the service name in docker-compose
    'username' => 'yii2user',
    'password' => 'yii2pass',
    'charset' => 'utf8',
];
