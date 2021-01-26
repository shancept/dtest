<?php


namespace app\controllers;


use app\components\Controller;
use app\models\Route;
use yii\web\NotFoundHttpException;

class RouteController extends Controller
{
	/**
	 * @param $request
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionIndex($request): string
	{
		$route = Route::find()->where(['url' => $request])->with(['toR', 'fromR'])->one();
		if($route) {
			$this->view->registerJsVar('calculateTo', $route->toR->city);
			$this->view->registerJsVar('calculateFrom', $route->fromR->city);
			return $this->render('index', ['route' => $route]);
		}
		throw new NotFoundHttpException('Страница не найдена');
	}
}