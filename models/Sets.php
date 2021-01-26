<?php

namespace app\models;

use Yii;
use Throwable;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%sets}}".
 *
 * @property string $key
 * @property-read Sets[] $data
 * @property string $value
 */
class Sets extends ActiveRecord
{
	public const TYPE_MAIL = -1;
	public const TYPE_GENERAL = 0;
	public const TYPE_HEADER = 1;
	public const TYPE_INTRO_SECTION = 2;
	public const TYPE_ABOUT_SECTION = 3;
	public const TYPE_CALCULATE_SECTION = 4;
	public const TYPE_NUMBERS_SECTION = 5;
	public const TYPE_PROVIDERS_SECTION = 6;
	public const TYPE_REF_ABOUT = 7;
	public const TYPE_REF_HOT = 8;
	public const TYPE_REF_COLD = 9;
	public const TYPE_TERMINAL_PAGE = 10;
	public const TYPE_CARGO_PAGE = 11;
	public const TYPE_ABOUT_PAGE = 12;

	/**
	 * @var self[]
	 */
	private $_data;

	/**
	 * @var self
	 */
	private static $_model;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string
	{
		return '{{%sets}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array
	{
		return [
			[['title', 'key', 'value', 'type'], 'required'],
			[['title', 'key', 'value'], 'string', 'max' => 255],
			[['type'], 'integer'],
			[['key'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(): array
	{
		return [
			'title' => 'Название',
			'key' => 'Key',
			'value' => 'Value',
			'type' => 'Type',
		];
	}

	/**
	 * @return Sets[]
	 */
	public function getData(): array
	{
		try {
			return $this->_data ?? $this->_data = self::getDb()->cache(function () {
					return self::find()->groupIndex(['type', 'key'])->all();
				});
		} catch (Throwable $e) {
			Yii::error($e->getMessage(), self::class);
			return [];
		}
	}

	/**
	 * @param $key
	 * @param int $type
	 * @param string $default
	 * @return string
	 */
	public function getValue($key, $type = self::TYPE_GENERAL, $default = ''): ?string
	{
		return $this->data[$type][$key]['value'] ?? $default;
	}

	/**
	 * @return self
	 */
	public static function model(): self
	{
		return self::$_model ?? self::$_model = new self();
	}

	/**
	 * {@inheritdoc}
	 * @return SetsQuery the active query used by this AR class.
	 */
	public static function find(): SetsQuery
	{
		return new SetsQuery(static::class);
	}
}
