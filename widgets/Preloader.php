<?php


namespace app\widgets;


use yii\base\Widget;
use yii\helpers\Html;

class Preloader extends Widget
{
	public function run()
	{
		return
			Html::tag('div',
				Html::tag('div',
					Html::tag('div',
						Html::tag('div', '', ['class' => 'cssload-speeding-wheel']),
						['class' => 'cssload-container']).Html::tag('p', 'Загрузка...'),
					['class' => 'preloader-body']),
				['class' => 'preloader']);
	}
}