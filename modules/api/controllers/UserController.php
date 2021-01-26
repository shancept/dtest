<?php
/**
 * Created by PhpStorm.
 * User: Shancept
 * Date: 01.04.19
 * Time: 15:57
 */

namespace app\modules\api\controllers;


use app\models\User;
use app\modules\api\components\Controller;
use Yii;
use yii\helpers\Json;
use yii\web\HttpException;

class UserController extends ApiController
{
	public function behaviors(): array
	{
		$behaviors = parent::behaviors();
		$behaviors['access']['rules'] = [
			[
				'actions' => ['auth'],
				'allow' => true,
				'roles' => ['?', '@'],
				'verbs' => ['GET']
			]
		];
		return $behaviors;
	}

	/**
	 * GET: /user/auth (login, password) - при успешном результате возвращает access_token
	 * @return array
	 * @throws HttpException
	 */
	public function actionAuth(): array
	{
		$login = Yii::$app->request->get('login', false);
		$password = Yii::$app->request->get('password', false);
		if ($login === false || $password === false) {
			throw new HttpException(400, 'Неверный запрос');
		}
		$user_identity = User::findByUsername($login);
		if ($user_identity === null) {
			return ['result' => 'error', 'errors' => 'Пользователь или пароль не верны'];
		}

		$auth = $user_identity->validatePassword($password);
		if (!$auth) {
			return ['result' => 'error', 'errors' => 'Пользователь или пароль не верны'];
		}

		return ['result' => 'success', 'access_token' => $user_identity->access_token];
	}

}