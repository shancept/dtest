<?php


namespace app\widgets\sections;


use app\widgets\elements\Container;
use app\widgets\elements\Row;
use app\widgets\elements\Section;
use yii\base\Widget;

class IntroBase extends Widget
{
	public $bgImage = '/images/banner.jpeg';
	public $content = '';

	public function run(): string
	{
		ob_start();
		Section::begin(['className' => ['section-md', 'section-intro', 'context-dark'], 'style' => "background: url(\"{$this->bgImage}\") no-repeat center; background-size: cover;", 'idName' => 'generalBanner']);
		Container::begin();
		Row::begin();
		$contentBegin = ob_get_clean();

		ob_start();
		Row::end();
		Container::end();
		Section::end();
		$contentEnd = ob_get_clean();

		return $contentBegin.$this->content.$contentEnd;
	}
}