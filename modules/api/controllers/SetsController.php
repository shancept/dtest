<?php


namespace app\modules\api\controllers;


use app\models\Sets;
use app\modules\api\components\Controller;
use Yii;
use yii\helpers\Json;

class SetsController extends Controller
{
	public function behaviors(): array
	{
		$behaviors = parent::behaviors();
		$behaviors['access']['rules'] = [
			[
				'actions' => ['index'],
				'allow' => true,
				'roles' => ['@'],
				'verbs' => ['GET', 'PUT']
			],
			[
				'actions' => ['index'],
				'allow' => true,
				'roles' => ['?', '@'],
				'verbs' => ['POST'],
			]
		];
		return $behaviors;
	}

	public function actionIndex()
	{
		if ($this->request->isPost) {
			$data = Json::decode($this->request->post('data', ''));
			foreach ($data as $item) {
				if($model = Sets::find()->where(['key' => $item['key'], 'type' => $item['type']])->one()) {
					$model->value = $item['value'];
					$model->save(false);
				}
			}
			Yii::$app->cache->flush();
			return ['result' => 'success'];
		}
	}
}