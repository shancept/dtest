<?php
/**
 * Created by PhpStorm.
 * User: Shancept
 * Date: 20.01.19
 * Time: 15:47
 */

namespace app\modules\api\filters;


use Yii;
use yii\filters\auth\QueryParamAuth;

class AccessTokenAuth extends QueryParamAuth
{
	/**
	 * {@inheritdoc}
	 */
	public function authenticate($user, $request, $response)
	{
		$accessToken = $request->input[$this->tokenParam] ?? '';
		if (is_string($accessToken)) {
			$identity = $user->loginByAccessToken($accessToken, get_class($this));
			if ($identity !== null) {
				return $identity;
			}
		}
		return Yii::$app->user;
	}

}