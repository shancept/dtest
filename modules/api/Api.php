<?php

namespace app\modules\api;

use Yii;
use yii\base\Module;
use app\modules\api\components\Profiler;

/**
 * api module definition class
 *
 * @property Profiler $profiler
 */
class Api extends Module
{

	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
		parent::init();
		Yii::$app->controllerNamespace = $this->controllerNamespace;
		Yii::$app->errorHandler->errorAction = '/api/error';
		Yii::$app->user->enableSession = false;
		Yii::$app->user->enableAutoLogin = false;
	}
}
