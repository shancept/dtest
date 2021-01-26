<?php

// comment out the following two lines when deployed to production
use app\models\Sets;
use yii\helpers\VarDumper;
use yii\base\ExitException;
use yii\base\InvalidConfigException;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

try {
	(new yii\web\Application($config))->run();
} catch (InvalidConfigException $e) {
	if(YII_DEBUG) {
		e($e);
	}
}


function d(...$vars)
{
	$content = ob_get_clean();
	foreach ($vars as $var) {
		VarDumper::dump($var, 20, true);
	}
	if ($content !== false) {
		ob_start();
		echo $content;
	}
}

function e(...$vars)
{
	$die = true;
	if (count($vars) > 1) {
		$die = array_pop($vars);
	}
	if ($vars) {
		d(...$vars);
	}
	if ($die) {
		die;
	}

	try {
		Yii::$app->end();
	} catch (ExitException $e) {
		die($e->getMessage());
	}
}

function s($key, $type, $default = '')
{
	return Sets::model()->getValue($key, $type, $default);
}