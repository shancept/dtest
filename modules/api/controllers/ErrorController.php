<?php


namespace app\modules\api\controllers;


use yii\rest\Controller;

class ErrorController extends Controller
{
	public function actionIndex(): array
	{
		return [
			'name' => 'Not Found Exception',
			'message' => 'Not Found',
			'code' => 0,
			'status' => 404
		];
	}
}