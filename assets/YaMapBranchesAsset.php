<?php


namespace app\assets;


use yii\web\View;

class YaMapBranchesAsset extends AssetBundle
{

	public $jsOptions = ['position' => View::POS_HEAD];

	public $js = [
		'js/vue/yamap-branches.js',
	];

	public $depends = [
		ApiMapsAsset::class
	];

}