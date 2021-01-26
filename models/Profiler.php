<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "{{%profiler}}".
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $path
 * @property string|null $request
 * @property string|null $headers
 * @property string|null $response
 * @property string|null $files
 * @property string|null $date
 * @property string|null $ip
 */
class Profiler extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string
	{
		return '{{%profiler}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array
	{
		return [
			[['request', 'headers', 'response', 'files'], 'string'],
			[['date'], 'safe'],
			[['type', 'path'], 'string', 'max' => 255],
			[['ip'], 'string', 'max' => 100],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(): array
	{
		return [
			'id' => 'ID',
			'type' => 'Тип',
			'path' => 'Путь',
			'request' => 'Запрос',
			'headers' => 'Заголовки',
			'response' => 'Ответ',
			'files' => 'Файлы',
			'date' => 'Данные',
			'ip' => 'Ip',
		];
	}

	/**
	 * @return bool
	 * @throws Exception
	 */
	public static function clear(): bool
	{
		return (bool)static::getDb()->createCommand()->truncateTable(static::tableName())->execute();
	}
}
