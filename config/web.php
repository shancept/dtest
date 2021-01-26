<?php

use yii\web\JsonResponseFormatter;
use yii\web\JsonParser;
use yii\rest\UrlRule;
use app\components\Mailer;
use yii\log\EmailTarget;
use yii\log\DbTarget;
use app\components\VueStore;
use yii\rbac\DbManager;
use app\modules\api\Api;
use app\modules\api\components\FileUpload;
use app\modules\api\components\Profiler;
use yii\debug\Module;
use app\models\User;
use yii\caching\FileCache;
use yii\web\Response;
use yii\web\UrlManager;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'language' => 'ru-RU',
	'sourceLanguage'=>'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
		'@admin' => '/admin',
		'@docs' => '@app/web/docs',
    ],
	'modules' => [
		'api' => [
			'class' => Api::class,
			'version' => '3.0.0',
			'components' => [
				'urlManager' => [
					'class' => UrlManager::class,
					'enablePrettyUrl' => true,
					'showScriptName' => false,
					'rules' => [
//						'/api/<controller:\w+>' => '<controller>/index',
//						'/api/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
					],
				],
				'profiler' => [
					'class' => Profiler::class,
				],
				'fileUpload' => [
					'class' => FileUpload::class
				]
			]
		],
	],
    'components' => [
		'request' => [
			'enableCsrfValidation' => true,
			'parsers' => [
				'application/json' => JsonParser::class,
			],
		],
		'response' => [
			'formatters' => [
				Response::FORMAT_JSON => [
					'class' => JsonResponseFormatter::class,
					'prettyPrint' => YII_DEBUG,
					'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
				],
			],
		],
        'cache' => [
            'class' => FileCache::class,
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'mail' => [
			'class' => Mailer::class,
			'useFileTransport' => true,
			'messageConfig' => [
				'charset' => 'UTF-8',
			],
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => null,
				'username' => null,
				'password' => null,
				'port' => '465',
				'encryption' => 'ssl',
			],
		],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
				[
					'class' => DbTarget::class,
					'levels' => ['error', 'warning'],
					'except' => [
						'yii\web\HttpException:404',
					],
				],
				[
					'class' => EmailTarget::class,
					'levels' => ['error'],
					'categories' => [
						'yii\db\*',
						Swift_SwiftException::class,
						Swift_TransportException::class,
						Swift_AddressEncoderException::class,
						Swift_DependencyException::class
					],
					'message' => [
					],
				],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
				['pattern' => 'admin', 'route' => 'admin/index', 'suffix'=>'/'],
				['pattern' => 'admin', 'route' => 'admin/index', 'suffix'=>''],
				'admin' => 'admin/index',
				'admin/<request:([A-Za-z0-9_\/-]+)>' => 'admin/index',
				'<action:login|logout|about|contacts|documents>' => 'site/<action>',
				'download/<filename:([A-Za-z\.0-9_\/-]+)>' => 'site/download',
				[
					'class' => UrlRule::class,
					'controller' => ['api/feedback', 'api/city', 'api/route'],
					'pluralize' => false
				],
				'/api/cache/flush' => 'api/cache/flush',
				'/api/route/save' => 'api/route/save',
				'<request:([A-Za-z0-9_\/-]+)>' => 'site/static'
            ],
        ],
		'authManager' => [
			'class' => DbManager::class,
		],
		'vueStore' => [
			'class' => VueStore::class,
		],
		'profiler' => [
			'class' => Profiler::class,
		],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => Module::class,
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
		'allowedIPs' => ['*'],
    ];
}

return $config;
