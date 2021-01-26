<?php


namespace app\modules\api\controllers;


use app\components\ArrayHelper;
use app\modules\api\actions\IndexAction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\HttpException;

class ApiController extends ActiveController
{
	public function behaviors(): array
	{
		$behaviors = parent::behaviors();
		$behaviors['access'] = [
			'class' => AccessControl::class,
			'denyCallback' => static function () {
				if (Yii::$app->user->authTimeout) {
					throw new HttpException(401, 'Токен истек');
				}

				throw new HttpException(403, 'Недостаточно прав');
			},
		];
		$behaviors['authenticator']['authMethods'] = [
			QueryParamAuth::class
		];
		if (YII_DEBUG) {
			$behaviors['corsFilter'] = ['class' => Cors::class];
		}
		return $behaviors;
	}

	public function actions(): array
	{
		return ArrayHelper::merge(parent::actions(), [
			'index' => [
				'class' => IndexAction::class,
			],
		]);
	}

}