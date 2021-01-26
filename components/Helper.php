<?php
/**
 * Created by PhpStorm.
 * User: Shancept
 * Date: 22.07.18
 * Time: 16:12
 */

namespace app\components;


use app\models\Sets;

class Helper
{
	public static function ruToTranslit($string): string
	{
		$converter = [
			'а' => 'a', 'б' => 'b', 'в' => 'v',
			'г' => 'g', 'д' => 'd', 'е' => 'e',
			'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
			'и' => 'i', 'й' => 'y', 'к' => 'k',
			'л' => 'l', 'м' => 'm', 'н' => 'n',
			'о' => 'o', 'п' => 'p', 'р' => 'r',
			'с' => 's', 'т' => 't', 'у' => 'u',
			'ф' => 'f', 'х' => 'h', 'ц' => 'c',
			'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
			'ь' => '', 'ы' => 'y', 'ъ' => '',
			'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

			'А' => 'A', 'Б' => 'B', 'В' => 'V',
			'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
			'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
			'И' => 'I', 'Й' => 'Y', 'К' => 'K',
			'Л' => 'L', 'М' => 'M', 'Н' => 'N',
			'О' => 'O', 'П' => 'P', 'Р' => 'R',
			'С' => 'S', 'Т' => 'T', 'У' => 'U',
			'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
			'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
			'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
			'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
			' ' => '_',
		];
		return strtolower(strtr($string, $converter));
	}

	public static function activeRecordToArray($ar): array
	{
		$array = [];
		foreach ($ar as $key => $value) {
			$array[$key] = $value;
		}
		return $array;
	}

	public static function randStr($len = 6): string
	{
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNMOPQRSTUVWXYZ0123456789';
		$str = '';
		for ($i = 0; $i < $len; $i++) {
			try {
				$str .= $chars[random_int(0, strlen($chars) - 1)];
			} catch (\Exception $e) {
			}
		}
		return $str;
	}

	public static function getPhone(): string
	{
		return Sets::model()->getValue('phone');
	}

	public static function getAddress(): string
	{
		return Sets::model()->getValue('address');
	}

	public static function getEmail(): string
	{
		return Sets::model()->getValue('email');
	}
}