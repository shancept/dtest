<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%providers}}".
 *
 * @property int $id
 * @property string $image
 * @property int $sort
 */
class Providers extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%providers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['sort', 'image'], 'required'],
            [['id', 'sort'], 'integer'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'sort' => 'Sort',
        ];
    }
}
