<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%services}}".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $icon
 * @property string $sort
 * @property string $description
 * @property string $bg_image
 * @property string $button
 * @property float $transparency
 */
class Services extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%services}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'url', 'icon', 'sort'], 'required'],
            [['id', 'sort'], 'integer'],
            [['title', 'url', 'icon', 'description'], 'string', 'max' => 255],
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
            'icon' => 'Icon',
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
