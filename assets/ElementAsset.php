<?php
/**
 * Created by PhpStorm.
 * User: Shancept
 * Date: 09.03.19
 * Time: 18:12
 */

namespace app\assets;


class ElementAsset extends AssetBundle
{
	public $js = [
		'js/element.js',
	];

	public $css = [
		'css/element.css',
	];

	public $depends = [
		VueAsset::class,
	];
}