<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\log\Logger;

/**
 * This is the ActiveQuery class for [[Log]].
 *
 * @see LogController
 */
class LogQuery extends ActiveQuery
{
    public function error(): self
	{
        return $this->andWhere('[[level]]='.Logger::LEVEL_ERROR);
    }

	public function warning(): self
	{
		return $this->andWhere('[[level]]='.Logger::LEVEL_WARNING);
	}

}
