<?php


namespace app\assets;


use yii\web\AssetBundle;

class VueAdminAsset extends AssetBundle
{
	public $baseUrl = '@admin';
	public $js = YII_DEBUG ? [
		'app.js',
		'hot-update.js',
	] : [
		'js/route.js',
		'js/city.js',
		'js/home.js',
		'js/log.js',
		'js/app.js',
		'js/chunk-vendors.js',
	];

	public $css = YII_DEBUG ? [
		'/css/admin/main.css',
	] : [
		'/css/admin/main.css',
		'css/route.css',
		'css/home.css',
		'css/city.css',
		'css/app.css',
		'css/chunk-vendors.css',
	];
}