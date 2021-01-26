<?php


namespace app\assets;

use yii\web\View;

class CalculateAsset extends AssetBundle
{
	public $jsOptions = ['position' => View::POS_HEAD];

	public $js = [
		'js/vue/calculate.js',
	];

	public $css = [
		'css/calculate.css'
	];
}