<?php


namespace app\components;


use yii\helpers\ReplaceArrayValue;
use yii\helpers\UnsetArrayValue;

class ArrayHelper extends \yii\helpers\ArrayHelper
{

	public static function merge($a, $b)
	{
		$args = func_get_args();
		$res = array_shift($args);
		while (!empty($args)) {
			foreach (array_shift($args) as $k => $v) {
				if ($v instanceof UnsetArrayValue) {
					unset($res[$k]);
				} elseif ($v instanceof ReplaceArrayValue) {
					$res[$k] = $v->value;
				}elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
					$res[$k] = static::merge($res[$k], $v);

				} elseif (is_int($k)) {
					if (array_key_exists($k, $res)) {
						$res[] = $v;
					} else {
						$res[$k] = $v;
					}
				} else {
					$res[$k] = $v;
				}
			}
		}

		return $res;
	}

	public static function getColumn($array, $attr, $keyAttr = null)
	{
		$column = [];
		foreach ($array as $key => $item) {
			$column[$keyAttr ? $item[$keyAttr] ?? null : $key] = $item[$attr] ?? null;
		}
		return $column;
	}
}