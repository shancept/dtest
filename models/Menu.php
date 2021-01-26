<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $sort
 */
class Menu extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%menu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id','title', 'url', 'sort'], 'required'],
            [['id', 'sort'], 'integer'],
            [['title', 'url'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
            'sort' => 'Sort',
        ];
    }

	/**
	 * {@inheritdoc}
	 * @return ActiveQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new ActiveQuery(static::class, ['orderBy' => ['sort' => SORT_ASC]]);
	}
}
