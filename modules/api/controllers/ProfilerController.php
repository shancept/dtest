<?php
/**
 * Created by PhpStorm.
 * User: Shancept
 * Date: 03.02.19
 * Time: 21:55
 */

namespace app\modules\api\controllers;


use app\modules\api\Api;
use app\modules\api\components\Controller;
use app\modules\api\components\Profiler;
use yii\helpers\Json;

/**
 *
 * @property-read Profiler $profiler
 */
class ProfilerController extends Controller
{
	public function getProfiler(): Profiler
	{
		return Api::getInstance()->profiler;
	}

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

	public function actionIndex(): array
	{
		if ($this->request->isDelete) {
			return ['result' => $this->profiler->clear()];
		}
		return [
			'list' => $this->profiler->profile,
			'attributeLabels' => (new \app\models\Profiler())->attributeLabels()
		];
	}

}