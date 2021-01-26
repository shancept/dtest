<?php


namespace app\widgets;


use yii\base\Widget;
use yii\helpers\Html;

class Dialog extends Widget
{
	public $title;

	public $beforeClose;

	public $visible;

	public static $context;

	public static function begin($config = [])
	{
		$widget = parent::begin($config);
		echo Html::beginTag('el-dialog', [
			'title' => $widget->title,
			'width' => '30%',
			':visible.sync' => $widget->visible,
			':before-close' => $widget->beforeClose,
		]);
		self::$context = $widget;
		return $widget;
	}

	public static function end()
	{
		$widget = parent::end();
		echo Html::endTag('el-dialog');
		return $widget;
	}
}