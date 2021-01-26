<?php

namespace app\models;

use app\components\ArrayHelper;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Sets]].
 *
 * @see Sets
 */
class SetsQuery extends ActiveQuery
{

	public $groupIndex = [];

	/**
	 * @param array $index
	 * @return SetsQuery
	 */
	public function groupIndex($index = []): SetsQuery
	{
		$this->groupIndex = $index;
		return $this;
	}

	public function populate($rows)
	{
		if($this->groupIndex) {
			$result = [];
			foreach ($rows as $row) {
				$indexes = [];
				foreach ($this->groupIndex as $index) {
					$indexes[] = ArrayHelper::getValue($row, $index);
				}
				$result = ArrayHelper::merge($result, $this->nestedArray($indexes, $row));
			}
			return $result;
		}
		return parent::populate($rows);
	}

	private function nestedArray($indexes, $value): array
	{
		$array = null;
		foreach (array_reverse($indexes) as $index) {
			$array = [$index => $array ?? $value];
		}
		return $array;
	}
}
