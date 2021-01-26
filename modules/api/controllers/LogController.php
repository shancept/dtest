<?php
/**
 * Created by PhpStorm.
 * User: Shancept
 * Date: 03.02.19
 * Time: 21:55
 */

namespace app\modules\api\controllers;


use app\models\Log;
use yii\db\Exception;
use app\modules\api\components\Controller;

class LogController extends Controller
{
	public function behaviors(): array
	{
		$behaviors = parent::behaviors();
		$behaviors['access']['rules'] = [
			[
				'actions' => ['index'],
				'allow' => true,
				'roles' => ['admin'],
				'verbs' => ['GET', 'DELETE']
			],
		];
		return $behaviors;
	}

	/**
	 * @return array
	 * @throws Exception
	 */
	public function actionIndex(): array
	{
		if ($this->request->isDelete) {
			return ['result' => Log::clear()];
		}
		if($this->request->isGet) {
			$log = Log::find()->error()->orderBy('id DESC')->limit(20);
			if($this->request->get('warning')) {
				$log->warning();
			}
			return [
				'list' =>$log->all(),
				'attributeLabels' => (new Log)->attributeLabels()
			];
		}
		return [];
	}

}