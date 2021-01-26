<?php


namespace app\assets;


use yii\web\View;

class YaMapAsset extends AssetBundle
{

	public $jsOptions = ['position' => View::POS_HEAD];

	public $js = [
		'js/vue/yamap.js',
	];

	public $depends = [
		ApiMapsAsset::class
	];

}