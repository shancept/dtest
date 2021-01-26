<?php


namespace app\widgets;


use app\models\City;
use yii\base\Widget;

class Branches extends Widget
{
	public function run()
	{
		return $this->render('branches', ['city' => City::find()->active()->orderBy('sort')->all()]);
	}
}