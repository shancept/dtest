<?php

namespace app\modules\api\controllers;


use app\components\ArrayHelper;
use app\models\City;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecordInterface;
use yii\web\NotFoundHttpException;

class CityController extends ApiController
{
	public $modelClass = City::class;

	public $createScenario = City::SCENARIO_INSERT;

	public function behaviors(): array
	{
		return ArrayHelper::merge(parent::behaviors(), [
			'access' => [
				'rules' => [
					[
						'actions' => ['search', 'index', 'item'],
						'allow' => true,
						'roles' => ['@'],
					],
					[
						'actions' => ['update'],
						'allow' => true,
						'roles' => ['admin'],
//						'verbs' => ['PUT'],
					],
				]
			],
			'authenticator' => [
				'authMethods' => [],
			]
		]);
	}

	public function actions(): array
	{
		return ArrayHelper::merge(parent::actions(), [
			'index' => [
				'prepareDataProvider' => function () {
					return new ActiveDataProvider([
						'query' => (new $this->modelClass)->find()->active(),
					]);
				},
			],
			'update' => [
				'findModel' => static function ($id, $action) {
					/* @var $modelClass ActiveRecordInterface */
					$modelClass = $action->modelClass;
					$model = $modelClass::findOne(['id' => $id, 'active' => 0]);
					if (isset($model)) {
						return $model;
					}
					throw new NotFoundHttpException("Object not found: $id");
				}
			],
		]);
	}

//
//	public function actionIndex()
//	{
//		if ($this->request->isGet) {
//			return [
//				'list' => City::find()->active()->all(),
//				'attributeLabels' => (new City())->attributeLabels()
//			];
//		}
//
//		if ($this->request->isPost) {
//			$post = $this->request->post();
//			if ($model = City::findOne(['id' => $post['id'], 'active' => 0])) {
//				$model->scenario = City::SCENARIO_INSERT;
//				$model->setAttributes($post);
//				return $model->save() ? ['result' => 'success'] : ['result' => 'error', 'errors' => $model->errors];
//			}
//
//			throw new HttpException(404, 'Нет модели');
//		}
//	}
//
//	/**
//	 * @param $id
//	 * @return array|string[]
//	 * @throws HttpException
//	 */
//	public function actionItem($id): ?array
//	{
//		if (null === $item = City::findOne(['id' => $id])) {
//			throw new HttpException(404, 'Не найдено');
//		}
//		if ($this->request->isPut) {
//			$item->scenario = City::SCENARIO_UPDATE;
//			$item->setAttributes($this->request->put());
//			return (bool)$item->save() ? ['result' => 'success'] : ['result' => 'error', 'errors' => $item->errors];
//		}
//
//		if ($this->request->isDelete) {
//			$item->active = 0;
//			return (bool)$item->save() ? ['result' => 'success'] : ['result' => 'error', 'errors' => $item->errors];
//		}
//	}
//
//	public function actionSearch(): ?array
//	{
//		if ($this->request->isGet) {
//			$query = $this->request->get('query');
//			return City::find()->where(['like', 'city', "$query%", false])->andFilterCompare('active', 0)->all();
//		}
//	}
}