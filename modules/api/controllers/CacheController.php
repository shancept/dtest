<?php

namespace app\modules\api\controllers;


use app\components\ArrayHelper;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\HttpException;

class CacheController extends Controller
{
	public function behaviors(): array
	{
		return ArrayHelper::merge(parent::behaviors(), [
			'access' => [
				'class' => AccessControl::class,
				'denyCallback' => static function () {
					if (Yii::$app->user->authTimeout) {
						throw new HttpException(401, 'Токен истек');
					}

					throw new HttpException(403, 'Недостаточно прав');
				},
				'rules' => [
					[
						'actions' => ['flush'],
						'allow' => true,
						'roles' => ['admin'],
						'verbs' => ['GET']
					],
				]
			],
			'authenticator' => [
				'authMethods' => [
					QueryParamAuth::class,
				],
			],
		]);
	}

	public function actionFlush()
	{
		\Yii::$app->cache->flush();
		return ['result' => 'success'];
	}
}