<?php


namespace app\controllers;


use app\components\Controller;
use app\models\Services;
use yii\web\NotFoundHttpException;

class ServiceController extends Controller
{

	/**
	 * @param $request
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionIndex($request): string
	{
		if($page = Services::find()->where(['url' => $request])->one()) {
			return $this->render($request, ['page' => $page]);
		}
		throw new NotFoundHttpException('Страница не найдена');
	}
}