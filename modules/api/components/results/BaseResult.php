<?php


namespace app\modules\api\components\results;


use yii\base\InvalidCallException;
use yii\base\Model;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

class BaseResult extends Model
{

	private $_attributes = [];

	public function __set($name, $value)
	{
		try {
			return parent::__set($name, $value);
		} catch (InvalidCallException $e) {
			$this->setAttribute($name, $value);
		} catch (UnknownPropertyException $e) {
			$this->setAttribute($name, $value);
		}
	}

	public function setAttribute($name, $value): void
	{
		$this->$name = $value;
		$this->_attributes[] = $name;
	}

	public function attributes(): array
	{
		return ArrayHelper::merge(parent::attributes(), $this->_attributes);
	}
}