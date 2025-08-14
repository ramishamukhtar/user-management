<?php
return [
    'id' => 'app-frontend-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'db' => require __DIR__ . '/test-db.php',
        'mailer' => [
            'class' => 'yii\symfonymailer\Mailer',
            'viewPath' => '@frontend/mail',
            'useFileTransport' => true,
        ],
        // no 'request' here for console
    ],
];
