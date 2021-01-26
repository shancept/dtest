<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Route]].
 *
 * @see Route
 */
class RouteQuery extends ActiveQuery
{
	public function routeFrom(): RouteQuery
	{
		$this->select('[[c.city]]');
		$this->alias('t');
		$this->join('LEFT JOIN', City::tableName().' c', '[[t.from]] = [[c.id]]');
		$this->distinct = true;
		return $this;
	}

	public function routeTo(): RouteQuery
	{
		$this->select('[[c.city]]');
		$this->alias('t');
		$this->join('LEFT JOIN', City::tableName().' c', '[[t.to]] = [[c.id]]');
		$this->distinct = true;
		return $this;
	}

	public function fromToRef($from, $to, $ref): RouteQuery
	{
		$this->select(['t.*', 'c2.city as cfrom', 'c1.city as cto']);
		$this->alias('t');
		$this->join('LEFT JOIN', City::tableName().' c2', '[[t.from]] = [[c2.id]]');
		$this->join('LEFT JOIN', City::tableName().' c1', '[[t.to]] = [[c1.id]]');
		$this->where(['c2.city' => $from, 'c1.city' => $to, 't.refrigerator' => $ref]);
		return $this;
	}
}
