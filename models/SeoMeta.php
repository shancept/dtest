<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%seo_meta}}".
 *
 * @property int $id
 * @property string $name
 * @property string $property
 * @property string $http_equiv
 *
 * @property SeoData[] $seoData
 */
class SeoMeta extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string
	{
		return '{{%seo_meta}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array
	{
		return [
			[['name', 'property', 'http_equiv'], 'string', 'max' => 255],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(): array
	{
		return [
			'id' => 'ID',
			'name' => 'Name',
			'property' => 'Property',
			'http_equiv' => 'Http Equiv',
		];
	}

	/**
	 * @return ActiveQuery
	 */
	public function getSeoData(): ActiveQuery
	{
		return $this->hasMany(SeoData::class, ['seo_meta_id' => 'id']);
	}
}
