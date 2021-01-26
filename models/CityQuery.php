<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[City]].
 *
 * @see City
 */
class CityQuery extends ActiveQuery
{
    public function active(): CityQuery
	{
        return $this->andWhere('[[active]]=1');
    }
}
