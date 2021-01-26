<?php


namespace app\widgets;


use Yii;
use yii\base\Widget;

class Services extends Widget
{
	public function run()
	{
		$request_url = substr(Yii::$app->request->url, 1);
		$services = Yii::$app->controller->services;
		return $this->render('services', [
			'services_chunk' => array_chunk($services, 2),
			'request_url' => $request_url,
			'transparency' => $services[$request_url]['transparency'] ?? 0.2
		]);
	}
}