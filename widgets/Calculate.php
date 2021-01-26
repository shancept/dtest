<?php


namespace app\widgets;


use yii\base\Widget;

class Calculate extends Widget
{

	public $refrigerator = false;

	public function run()
	{
		return $this->render('calculate/index', ['isRefrigerator' => $this->refrigerator]);
	}
}