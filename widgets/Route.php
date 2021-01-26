<?php


namespace app\widgets;


use yii\base\Widget;

class Route extends Widget
{

	public function run()
	{
		$route = \app\models\Route::find()->where(['refrigerator' => 0])->with(['toR', 'fromR'])->all();
		shuffle($route);
		return $this->render('route', ['route' => $route]);
	}
}