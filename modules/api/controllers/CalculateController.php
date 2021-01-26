<?php
/**
 * Created by PhpStorm.
 * User: Shancept
 * Date: 10.05.19
 * Time: 0:00
 */

namespace app\modules\api\controllers;


use app\models\Feedback;
use app\models\Route;
use app\models\RouteQuery;
use app\modules\api\Api;
use app\modules\api\components\Controller;
use app\modules\api\models\FileUpload;
use yii\helpers\Json;
use yii\web\HttpException;

class CalculateController extends Controller
{
	public function behaviors(): array
	{
		$behaviors = parent::behaviors();
		$behaviors['access']['rules'] = [
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
			$post = $this->request->post();
			$route = Route::find()->fromToRef($post['from'], $post['to'], $post['refrigerator'])->one();
			if(is_null($route)) {
				return ['price' => 0];
			}
			return [
				'price' => $route->getPrice(abs((float)$post['weight']), abs((float)$post['volume'])),
				'delivery_time' => $route->delivery_time
			];
		}
		return ['price' => 0];
	}
}