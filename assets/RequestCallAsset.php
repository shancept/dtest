<?php


namespace app\assets;

use yii\web\View;

class RequestCallAsset extends AssetBundle
{

	public $jsOptions = ['position' => View::POS_HEAD];

	public $js = [
		'js/vue/request-call.js',
	];

	public $css = [
		'css/request-call.css'
	];

}