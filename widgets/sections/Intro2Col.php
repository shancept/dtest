<?php


namespace app\widgets\sections;


use yii\helpers\Html;

class Intro2Col extends IntroBase
{
	public $col1 = '';
	public $col2 = '';

	public function init()
	{
		$col1 = Html::tag('div', $this->col1, ['class' => 'col-xl-6']);
		$col2 = Html::tag('div', $this->col2, ['class' => 'col-xl-6']);
		$this->content = $col1.$col2;
		parent::init();
	}
}