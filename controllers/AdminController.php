<?php
/**
 * Created by PhpStorm.
 * User: Shancept
 * Date: 01.04.19
 * Time: 17:37
 */

namespace app\controllers;


use app\assets\VueAdminAsset;
use app\components\Controller;
use app\models\City;
use app\models\Route;
use app\models\Sets;
use Yii;
use yii\filters\AccessControl;
use yii\web\JsExpression;

class AdminController extends Controller
{
	public $layout = 'admin';

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'actions' => ['index'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			]
		];
	}

	public function actionIndex()
	{
		$sets = Sets::model()->data;
		Yii::$app->vueStore->pushStates([
			'user' => Yii::$app->user->identity->username,
			'siteSets' => [
				'Конфиг' => array_values($sets[Sets::TYPE_GENERAL] ?? [])
			],
			'mailSets' => [
				'Конфиг' => array_values($sets[Sets::TYPE_MAIL] ?? [])
			],
			'generalPageSets' => [
				'Шапка' => array_values($sets[Sets::TYPE_HEADER] ?? []),
				'Блок баннер' => array_values($sets[Sets::TYPE_INTRO_SECTION] ?? []),
				'Блок о компании' => array_values($sets[Sets::TYPE_ABOUT_SECTION] ?? []),
				'Блок калькулятор' => array_values($sets[Sets::TYPE_CALCULATE_SECTION] ?? []),
				'Блок цифры' => array_values($sets[Sets::TYPE_NUMBERS_SECTION] ?? []),
				'Блок нам доверяют' => array_values($sets[Sets::TYPE_PROVIDERS_SECTION] ?? []),
			],
			'aboutPageSets' => [
				'Текст о компании' => array_values($sets[Sets::TYPE_ABOUT_PAGE] ?? []),
				'Текст' => array_values($sets[Sets::TYPE_ABOUT_SECTION] ?? []),
				'Блок нам доверяют' => array_values($sets[Sets::TYPE_PROVIDERS_SECTION] ?? []),
			],
			'refrigeratorPageSets' => [
				'Текст о' => array_values($sets[Sets::TYPE_REF_ABOUT] ?? []),
				'Опыт с заморозкой 1' => array_values($sets[Sets::TYPE_REF_HOT] ?? []),
				'Опыт с заморозкой 2' => array_values($sets[Sets::TYPE_REF_COLD] ?? []),
			],
			'terminalServicesPageSets' => [
				'Блок' => array_values($sets[Sets::TYPE_TERMINAL_PAGE] ?? []),
			],
			'groupageCargoPageSets' => [
				'Блок' => array_values($sets[Sets::TYPE_CARGO_PAGE] ?? []),
			],
			'city' => [
				'list' => City::find()->active()->all(),
				'attributeLabels' => (new City())->attributeLabels()
			],
			'route' => [
				'list' => Route::find()->with(['fromR', 'toR'])->asArray()->all(),
				'attributeLabels' => (new Route())->attributeLabels()
			]
		]);

		$this->view->registerJsVar('dataStore', new JsExpression(Yii::$app->vueStore->store));
		VueAdminAsset::register($this->view);
		return $this->renderPartial('/layouts/admin');
	}
}