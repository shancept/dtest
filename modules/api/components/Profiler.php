<?php

namespace app\modules\api\components;


use app\models\Sets;
use yii\base\Component;
use yii\helpers\Json;

/**
 *
 * @property array $profile
 */
class Profiler extends Component
{
	public $type;
	public $path;
	public $request;
	public $files;
	public $headers;
	public $response;
	public $ip;

	private $_active;

	public function init()
	{
		$this->setActive((bool)Sets::model()->getValue('profiler'));
		/**
		 * @var $request Request
		 */
		$request = \Yii::$app->request;

		$this->type = $request->method;
		$this->path = $request->pathInfo;
		$this->ip = $request->userIP;
		$this->request = $request->input;
		$this->files = $_FILES;
		$this->headers = $request->headers->toArray();
	}

	/**
	 * @param bool $active
	 */
	public function setActive(bool $active): void
	{
		$this->_active = $active;
	}

	/**
	 * @return Profiler[]
	 */
	public function getProfile(): array
	{
		return \app\models\Profiler::find()->orderBy('date DESC')->orderBy('id DESC')->limit(20)->all();
	}

	public function setResponse($response): self
	{
		$this->response = $response;
		return $this;
	}

	public function save(): int
	{
		$rows = 0;
		if($this->_active && $this->path !== 'api/profiler') {
			$model = new \app\models\Profiler();
			$model->setAttributes([
				'type' => $this->type,
				'path' => $this->path,
				'ip' => $this->ip,
				'request' => Json::encode($this->request),
				'files' => Json::encode($this->files),
				'headers' => Json::encode($this->headers),
				'response' => $this->response,
				'date' => (new \DateTime)->setTimezone(new \DateTimeZone('Asia/Novosibirsk'))->format('Y-m-d H:i:s'),
			]);
			$model->save();
		}
		return $rows;
	}

	public function clear(): bool
	{
		return \app\models\Profiler::clear();
	}
}