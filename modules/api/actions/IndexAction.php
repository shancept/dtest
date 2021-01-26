<?php

namespace app\modules\api\actions;


class IndexAction extends \yii\rest\IndexAction
{

	public function run()
	{
		if ($this->checkAccess) {
			call_user_func($this->checkAccess, $this->id);
		}

		return [
			'list' => $this->prepareDataProvider(),
			'attributeLabels' => (new $this->modelClass())->attributeLabels()
		];
	}

}