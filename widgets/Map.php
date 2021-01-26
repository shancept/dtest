<?php

namespace app\widgets;


use app\models\City;
use yii\base\Widget;

class Map extends Widget
{
	/**
	 * @var City
	 */
	public $city;

	public function run()
	{
		if($this->city) {
			return $this->render('mapBranches', ['city' => $this->city]);
		}
		$this->view->registerJsVar('VCityList', City::find()->active()->all());
		return $this->render('map');
	}
}