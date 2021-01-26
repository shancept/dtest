<?php

namespace app\models;

use DateTime;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[Feedback]].
 *
 * @see Feedback
 */
class FeedbackQuery extends ActiveQuery
{
	public function new(): self
	{
		return $this->andWhere('[[status]]='.Feedback::STATUS_NEW);
	}

	public function feedback(): self
	{
		$this->new();
		$this->orWhere(new Expression('[[status]]= :status AND [[date]] >= :date', [
			':date' => (new DateTime('today - 1 month'))->format('Y-m-d H:i:s'),
			':status' => Feedback::STATUS_PROCESSED,
		]));
		$this->orderBy('STATUS, date DESC');
		return $this;
	}
}
