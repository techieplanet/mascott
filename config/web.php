<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone' => 'Africa/Lagos',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '70jTA99RfGwRQgEorTy7o83Z0QLe2qss',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['index/site'],
            //'permissions' => []
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['masadmin@nafdac.gov.ng' => 'NAFDAC MAS'],
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
               // 'host' => 'mail.techieplanetltd.com',
                'host' => 'smtp.gmail.com',
                //'host' => 'smtp.gbb.com.ng',
                //'username' => 'devtest@techieplanetltd.com',
                'username' => 'nafdacmastest@gmail.com',
                //'username' => 'masadmin@nafdac.gov.ng',
                'password' => 'nafdacmastest!20',
                //'password' => 'Password1',
                //'password' => 'devtest112',
                //'port' => '587',
                //'port' => '465',
                'port' =>'587',
                'encryption' => 'TLS'
            ],
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

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => false,
            'rules' => [
              ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
            ],
        ]
    ],

    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
        ],
        'api' => [
            'class' => 'app\api\API',
        ],
    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
