<?php


namespace app\assets;


use yii\web\View;

class ApiMapsAsset extends AssetBundle
{
	public $jsOptions = ['position' => View::POS_HEAD];

	public $js = [
		'https://api-maps.yandex.ru/2.1/?apikey=',
	];

}