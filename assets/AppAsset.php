<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $css = [
        'css/bootstrap.css',
		'css/fonts.css',
        'css/style.css',
        'css/custom.css',
        'css/services.css',
    ];
    public $js = [
		'js/main.js',
		'js/core.min.js',
		'js/script.js',
    ];

    public $depends = [
		ElementAsset::class,
	];
}
