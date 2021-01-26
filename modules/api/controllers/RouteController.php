<?php

namespace app\modules\api\controllers;


use app\components\ArrayHelper;
use app\models\Route;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;

class RouteController extends ApiController
{
	public $modelClass = Route::class;

	public function behaviors(): array
	{
		return ArrayHelper::merge(parent::behaviors(), [
			'access' => [
				'rules' => [
					[
						'actions' => ['index', 'create', 'update', 'delete', 'save'],
						'allow' => true,
						'roles' => ['manager'],
					],
				]
			]
		]);
	}

	protected function verbs()
	{
		return ArrayHelper::merge(parent::verbs(), [
			'save' => ['PUT']
		]);
	}

	public function actions(): array
	{
		return ArrayHelper::merge(parent::actions(), [
			'index' => [
				'prepareDataProvider' => function () {
					return new ActiveDataProvider([
						'query' => (new $this->modelClass)->find()->with(['fromR', 'toR'])->asArray(),
					]);
				},
			],
			'create' => [
				'scenario' => Route::SCENARIO_INSERT,
			],
			'update' => [
				'scenario' => Route::SCENARIO_UPDATE,
			],
		]);
	}

	/**
	 * @return array
	 */
	public function actionSave(): array
	{
		$res = [];
		$routes = Route::getAllIndexed();
		foreach (Yii::$app->getRequest()->getBodyParams() as $item) {
			$key = "{$item['from']}_{$item['to']}_{$item['refrigerator']}";
			if (isset($routes[$key])) {
				$routes[$key]->setAttributes($item);
				$res[$key]['result'] = (bool)$routes[$key]->save() ? 'success' : 'error';
				$res[$key]['errors'] = $routes[$key]->errors;
			}
		}
		return $res;
	}

}