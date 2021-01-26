<?php

namespace app\models;

use app\components\Helper;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_route".
 *
 * @property int $from
 * @property int $to
 * @property int $refrigerator
 * @property float $w500
 * @property float $w1000
 * @property float $w2000
 * @property float $w3000
 * @property float $w4000
 * @property float $w5000
 * @property float $v1
 * @property float $v3
 * @property float $v5
 * @property float $v10
 * @property float $v20
 * @property float $v30
 * @property string $url
 * @property string $delivery_time
 *
 * @property City $fromR
 * @property City $toR
 */
class Route extends ActiveRecord
{
	public const SCENARIO_INSERT = 'insert';
	public const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'tbl_route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
			[['from', 'to'], 'required'],
			[['from', 'to'], 'cityValidator', 'on' => [self::SCENARIO_INSERT]],
			['refrigerator', 'default', 'value' => 0, 'on' => [self::SCENARIO_INSERT, self::SCENARIO_DEFAULT, self::SCENARIO_UPDATE]],
            [['w500', 'w1000', 'w2000', 'w3000', 'w4000', 'w5000', 'v1', 'v3', 'v5', 'v10', 'v20', 'v30'], 'number', 'on' => [self::SCENARIO_INSERT, self::SCENARIO_DEFAULT, self::SCENARIO_UPDATE]],
            [['w500', 'w1000', 'w2000', 'w3000', 'w4000', 'w5000', 'v1', 'v3', 'v5', 'v10', 'v20', 'v30'], 'default', 'value' => 0],
            [['from'], 'unique', 'targetAttribute' => ['from', 'to', 'refrigerator'], 'message' => 'Комбинация параметров {attributes} уже существует.'],
            [['from'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['from' => 'id']],
            [['to'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['to' => 'id']],
			[['url', 'delivery_time'], 'string', 'on' => [self::SCENARIO_INSERT, self::SCENARIO_DEFAULT, self::SCENARIO_UPDATE]],
        ];
    }

    public function cityValidator($attr, $params): void
	{
		$city = City::find()->where(['city' => $this->$attr])->one();
		if($city === null) {
			$this->addError($attr, 'Нет такого города');
		} else {
			$this->$attr = $city->id;
		}
	}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'from' => 'Откуда',
            'fromR' => 'Откуда',
            'to' => 'Куда',
            'toR' => 'Куда',
            'refrigerator' => 'Рефрижератор',
            'w500' => 'До 500кг',
            'w1000' => 'От 501 - 1000кг',
            'w2000' => 'От 1001 - 2000кг',
            'w3000' => 'От 2001 - 3000кг',
            'w4000' => 'От 3001 - 4000кг',
            'w5000' => 'От 4001 - 5000кг',
            'v1' => 'До 1 м3',
            'v3' => 'От 1 - 3 м3',
            'v5' => 'От 3 - 5 м3',
            'v10' => 'От 5 - 10 м3',
            'v20' => 'От 10 - 20 м3',
            'v30' => 'От 20 - 30 м3',
            'url' => 'Url',
            'delivery_time' => 'Срок доставки',
        ];
    }

    /**
     * Gets query for [[FromR]].
     *
     * @return ActiveQuery|CityQuery
     */
    public function getFromR()
    {
        return $this->hasOne(City::class, ['id' => 'from']);
    }

    /**
     * Gets query for [[ToR]].
     *
     * @return ActiveQuery|CityQuery
     */
    public function getToR()
    {
        return $this->hasOne(City::class, ['id' => 'to']);
    }

    /**
     * {@inheritdoc}
     * @return RouteQuery the active query used by this AR class.
     */
    public static function find(): RouteQuery
    {
        return new RouteQuery(static::class);
    }

	/**
	 * @param float $weight
	 * @return string
	 * @throws Exception
	 */
    public function getWeight(float $weight): string
	{
		if ($weight < 501) {
			return $this->w500;
		}

		if ($weight >= 500 && $weight < 1001) {
			return $this->w1000;
		}

		if ($weight >= 1000 && $weight < 2001) {
			return $this->w2000;
		}

		if ($weight >= 2000 && $weight < 3001) {
			return $this->w3000;
		}

		if ($weight >= 3000 && $weight < 4001) {
			return $this->w4000;
		}

		if ($weight >= 4000 && $weight < 20001) {
			return $this->w5000;
		}
		throw new Exception('weight incorrect');
	}

	/**
	 * @param float $volume
	 * @return string
	 * @throws Exception
	 */
	public function getVolume(float $volume): string
	{
		if ($volume < 1) {
			return $this->v1;
		}

		if ($volume >= 1 && $volume < 3) {
			return $this->v3;
		}

		if ($volume >= 3 && $volume < 5) {
			return $this->v5;
		}

		if ($volume >= 5 && $volume < 10) {
			return $this->v10;
		}

		if ($volume >= 10 && $volume < 20) {
			return $this->v20;
		}

		if ($volume >= 20 && $volume < 110) {
			return $this->v30;
		}
		throw new Exception('volume incorrect');
	}

	/**
	 * @param float|int $weight
	 * @param float|int $volume
	 * @return int
	 */
	public function getPrice($weight = 0, $volume = 0): int
	{
		try {
			$w = $this->getWeight($weight);
			$v = $this->getVolume($volume);
		} catch (Exception $e) {
			return 0;
		}
		$totalW = $w * $weight;
		$totalV = $v * $volume;
		if($totalW > $totalV) {
			return ceil($totalW);
		}
		return ceil($totalV);
	}

	public function beforeSave($insert)
	{
		if (!$this->isNewRecord) {
			$this->url = Helper::ruToTranslit($this->toR->city ?? ''.'-'.$this->fromR->city ?? '');
			foreach ($this->attributes as $key => $attribute) {
				if ((float)$attribute !== (float)$this->oldAttributes[$key]) {
					return parent::beforeSave($insert);
				}
			}
			return false;
		}
		return parent::beforeSave($insert);
	}

	/**
	 * @return self[]
	 */
	public static function getAllIndexed(): array
	{
		$res = [];
		/** @var self $item */
		foreach (self::find()->all() as $item) {
			$res["{$item['from']}_{$item['to']}_{$item['refrigerator']}"] = $item;
		}
		return $res;
	}
}
