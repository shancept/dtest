<?php


namespace app\components;


use app\models\Sets;
use Swift_Transport;
use yii\base\InvalidConfigException;

class Mailer extends \yii\swiftmailer\Mailer
{
	/**
	 * @param array|Swift_Transport $transport
	 * @throws InvalidConfigException
	 */
	public function setTransport($transport)
	{
		if (is_array($transport)) {
			$transport = ArrayHelper::merge($transport, ArrayHelper::getColumn(Sets::model()->data[Sets::TYPE_MAIL] ?? [], 'value'));
		}
		parent::setTransport($transport);
	}
}