<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%feedback}}".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string|null $email
 * @property string|null $city
 * @property string|null $volume
 * @property string|null $weight
 * @property int|null $oversized_cargo
 * @property int|null $refrigerator
 * @property string|null $from
 * @property string|null $to
 * @property string $page
 * @property string|null $message
 * @property string|null $date
 * @property int|null $status
 * @property int|null $type
 */
class Feedback extends ActiveRecord
{
	public const SCENARIO_PROCESSED = 'processed';

	public const STATUS_NEW = 1;
	public const STATUS_PROCESSED = 2;

	public const TYPE_CALCULATE = 1;
	public const TYPE_RECALL = 2;

	private $notify = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%feedback}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'phone'], 'required'],
			[['oversized_cargo', 'refrigerator'], 'integer'],
			[['message'], 'string'],
            [['date'], 'safe'],
            [['name', 'phone', 'email', 'city', 'volume', 'weight', 'from', 'to', 'page'], 'string', 'max' => 255],
            [['status', 'type'], 'integer'],
        ];
    }

	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_PROCESSED] = ['status',];
		return $scenarios;
	}

	public function beforeSave($insert)
	{
		$this->date = (new \DateTime)->setTimezone(new \DateTimeZone('Asia/Novosibirsk'))->format('Y-m-d H:i:s');
		if ($this->isNewRecord) {
			$this->status = self::STATUS_NEW;
			$this->page = Yii::$app->request->referrer;
			$this->notify = true;
		}
		if($this->scenario === self::SCENARIO_PROCESSED) {
			$this->status = self::STATUS_PROCESSED;
		}
		return parent::beforeSave($insert);
	}

	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);
		if($this->notify) {
			try {
				Yii::$app->mail
					->compose('feedback', ['feedback_model' => $this])
					->setTo(Yii::$app->mail->transport->getUsername())
					->setSubject('Сообщение с сайта')
					->send();
			} catch (\Exception $e) {
				Yii::error($e->getMessage(), self::class);
			}
		}
	}

	/**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Email',
            'city' => 'Город',
            'volume' => 'Объем',
            'weight' => 'Вес',
            'oversized_cargo' => 'Негабаритный груз',
			'refrigerator' => 'Рефрижератор',
            'from' => 'Направление откуда',
            'to' => 'Направление куда',
            'page' => 'Страница',
            'message' => 'Сообщение',
            'date' => 'Дата',
        ];
    }

	/**
	 * {@inheritdoc}
	 * @return FeedbackQuery the active query used by this AR class.
	 */
	public static function find(): FeedbackQuery
	{
		return new FeedbackQuery(static::class);
	}
}
