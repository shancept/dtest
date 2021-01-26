<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%seo_data}}".
 *
 * @property int $id
 * @property int $seo_id
 * @property int $seo_meta_id
 * @property string $content
 *
 * @property SeoMeta $seoMeta
 * @property Seo $seo
 */
class SeoData extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string
	{
		return '{{%seo_data}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array
	{
		return [
			[['seo_id', 'seo_meta_id'], 'required'],
			[['seo_id', 'seo_meta_id'], 'integer'],
			[['content'], 'string'],
			[['seo_meta_id'], 'exist', 'skipOnError' => true, 'targetClass' => SeoMeta::class, 'targetAttribute' => ['seo_meta_id' => 'id']],
			[['seo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Seo::class, 'targetAttribute' => ['seo_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(): array
	{
		return [
			'id' => 'ID',
			'seo_id' => 'Seo ID',
			'seo_meta_id' => 'Seo Meta ID',
			'content' => 'Content',
		];
	}

	public static function removeOld($seo_id): void
	{
		$model = self::find()->where(['seo_id' => $seo_id])->all();
		foreach ($model as $value) {
			$value->delete();
		}
	}

	public static function addAll($data): void
	{
		foreach ($data as $value) {
			$model = new self();
			$model->seo_id = $value['seo_id'];
			$model->seo_meta_id = $value['seo_meta_id'];
			$model->content = $value['content'];
			$model->save();
		}
	}

	/**
	 * @return ActiveQuery
	 */
	public function getSeoMeta(): ActiveQuery
	{
		return $this->hasOne(SeoMeta::class, ['id' => 'seo_meta_id']);
	}

	/**
	 * @return ActiveQuery
	 */
	public function getSeo(): ActiveQuery
	{
		return $this->hasOne(Seo::class, ['id' => 'seo_id']);
	}
}
