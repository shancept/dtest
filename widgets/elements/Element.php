<?php


namespace app\widgets\elements;


use yii\base\Widget;
use yii\helpers\Html;

abstract class Element extends Widget
{
	public $style = '';
	protected $className = [];
	protected $idName = '';
	protected $tagName = 'div';

	/**
	 * @param array $className
	 */
	public function setClassName(array $className): void
	{
		foreach ($className as $item) {
			$this->className[] = $item;
		}
	}

	/**
	 * @param string $idName
	 */
	public function setIdName(string $idName): void
	{
		$this->idName = $idName;
	}

	public function getClassName(): array
	{
		return $this->className;
	}

	/**
	 * @return string
	 */
	public function getIdName(): string
	{
		return $this->idName;
	}

	public static function begin($config = [])
	{
		$widget = parent::begin($config);
		$params = [];
		if($widget->className) {
			$params['class'] = $widget->className;
		}
		if($widget->idName) {
			$params['id'] = $widget->idName;
		}
		if($widget->style) {
			$params['style'] = $widget->style;
		}
		echo Html::beginTag($widget->tagName, $params);
		return $widget;
	}

	public static function end()
	{
		$widget = parent::end();
		echo Html::endTag($widget->tagName);
		return $widget;
	}
}