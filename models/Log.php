<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "tbl_log".
 *
 * @property int $id
 * @property int|null $level
 * @property string|null $category
 * @property float|null $log_time
 * @property string|null $prefix
 * @property string|null $message
 */
class Log extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['level'], 'integer'],
            [['log_time'], 'number'],
            [['prefix', 'message'], 'string'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'level' => 'Уровень',
            'category' => 'Категория',
            'log_time' => 'Время',
            'prefix' => 'Prefix',
            'message' => 'Сообщение',
        ];
    }

    /**
     * {@inheritdoc}
     * @return LogQuery the active query used by this AR class.
     */
    public static function find(): LogQuery
    {
        return new LogQuery(static::class);
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
