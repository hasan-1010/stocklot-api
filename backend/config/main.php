<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\Api',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'user',
                    'extraPatterns'=>[
                        'GET index' => 'index',
                        'POST login' => 'login',
                        'POST signup' => 'signup'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'category',
                    'extraPatterns'=>[
                        'GET index' => 'index',
                        'GET get-category' => 'get-category'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'stock',
                    'extraPatterns'=>[
                        'GET test' => 'test',
                        'GET get-all-stock' => 'get-all-stock',
                        'POST create-stock' => 'create-stock'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'attribute',
                    'extraPatterns'=>[
                        'GET test' => 'test',
                        'GET get-all-attribute' => 'get-all-attribute',
                    ],
                ],
            ],
        ],
        // 'urlManagerFrontend' => [
        //     'class'           => 'yii\web\UrlManager',
        //     'baseUrl'         => 'frontend/web/',
        //     'enablePrettyUrl' => true,
        //     'showScriptName'  => false,
        // ],
        
    ],
    'params' => $params,
];
