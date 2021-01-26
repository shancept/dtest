<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_city".
 *
 * @property int $id
 * @property string|null $address
 * @property string|null $country
 * @property string|null $federal_district
 * @property string|null $region_type
 * @property string|null $region
 * @property string|null $area_type
 * @property string|null $area
 * @property string|null $city_type
 * @property string|null $city
 * @property string|null $timezone
 * @property float|null $geo_lat
 * @property float|null $geo_lon
 * @property int $active
 * @property string $adds [varchar(100)]
 * @property string $tel [varchar(100)]
 * @property string $tel2 [varchar(100)]
 * @property string $company [varchar(100)]
 * @property int $sort
 * @property string $image
 */
class City extends ActiveRecord
{
	public const SCENARIO_INSERT = 1;
	public const SCENARIO_UPDATE = 2;
	public const SCENARIO_IMPORT = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'tbl_city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['geo_lat', 'geo_lon'], 'number', 'on' => [self::SCENARIO_INSERT, self::SCENARIO_UPDATE]],
			[['active'], 'integer', 'on' => [self::SCENARIO_IMPORT]],
            [['address'], 'string', 'max' => 255, 'on' => [self::SCENARIO_IMPORT]],
            [['country'], 'string', 'max' => 50, 'on' => [self::SCENARIO_IMPORT]],
            [['federal_district', 'region', 'area', 'city'], 'string', 'max' => 100, 'on' => [self::SCENARIO_IMPORT]],
            [['region_type', 'area_type', 'city_type', 'timezone'], 'string', 'max' => 11, 'on' => [self::SCENARIO_IMPORT]],
			[['tel', 'tel2', 'adds', 'company', 'image'], 'safe', 'on' => [self::SCENARIO_INSERT, self::SCENARIO_UPDATE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID города',
            'address' => 'Адрес города',
            'country' => 'Страна',
            'federal_district' => 'Федеральный округ',
            'region_type' => 'Тип региона',
            'region' => 'Регион',
            'area_type' => 'Тип района',
            'area' => 'Район',
            'city_type' => 'Тип города',
            'city' => 'Город',
            'timezone' => 'Часовой пояс',
            'geo_lat' => 'Широта',
            'geo_lon' => 'Долгота',
			'active' => 'Активен',
			'tel' => 'Телефон',
			'tel2' => 'Телефон 2',
			'company' => 'Компания',
			'adds' => 'Адрес',
			'image' => 'Путь изображения',
        ];
    }

    public function beforeSave($insert)
	{
		if($this->scenario === self::SCENARIO_INSERT) {
			$this->active = 1;
		}
		return parent::beforeSave($insert);
	}

	public static function find()
	{
		return new CityQuery(static::class);
	}
}
