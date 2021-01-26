<?php

namespace app\modules\api\controllers;

use app\models\Feedback;
use app\components\ArrayHelper;
use yii\data\ActiveDataProvider;

class FeedbackController extends ApiController
{
	public $modelClass = Feedback::class;

	public function behaviors(): array
	{
		return ArrayHelper::merge(parent::behaviors(), [
			'access' => [
				'rules' => [
					[
						'actions' => ['index', 'view', 'update'],
						'allow' => true,
						'roles' => ['manager'],
					],
				]
			],
			'authenticator' => [
				'optional' => [
					'create'
				]
			]
		]);
	}

	public function actions(): array
	{
		return ArrayHelper::merge(parent::actions(), [
			'index' => [
				'prepareDataProvider' => function () {
					return new ActiveDataProvider([
						'query' => (new $this->modelClass)->find()->feedback(),
					]);
				},
			],
			'update' => [
				'scenario' => Feedback::SCENARIO_PROCESSED,
			],
		]);
	}
}