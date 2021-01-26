<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%seo}}".
 *
 * @property int $id
 * @property string $url
 * @property string $title
 * @property string $h1
 *
 * @property SeoData[] $seoData
 */
class Seo extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string
	{
		return '{{%seo}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array
	{
		return [
			[['url'], 'required'],
			[['url', 'title', 'h1'], 'string', 'max' => 255],
			[['url'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(): array
	{
		return [
			'id' => 'ID',
			'url' => 'Url',
			'title' => 'Title',
			'h1' => 'H1',
		];
	}

	/**
	 * @return ActiveQuery
	 */
	public function getSeoData(): ActiveQuery
	{
		return $this->hasMany(SeoData::class, ['seo_id' => 'id']);
	}
}
