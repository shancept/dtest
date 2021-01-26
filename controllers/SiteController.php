<?php

namespace app\controllers;

use app\components\Controller;
use app\models\City;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\Route;
use Yii;
use yii\base\InvalidRouteException;
use yii\captcha\CaptchaAction;
use yii\console\Exception;
use yii\filters\AccessControl;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => ErrorAction::class,
			],
			'captcha' => [
				'class' => CaptchaAction::class,
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * @param $request
	 * @return int|mixed|\yii\console\Response
	 * @throws NotFoundHttpException
	 */
	public function actionStatic($request)
	{
		try {
			return \Yii::$app->runAction('route/index', ['request' => $request]);
		} catch (NotFoundHttpException $e) {
			try {
				return \Yii::$app->runAction('service/index', ['request' => $request]);
			} catch (InvalidRouteException $e) {
				throw new NotFoundHttpException('Страница не найдена');
			} catch (Exception $e) {
				throw new NotFoundHttpException('Страница не найдена');
			}
		} catch (InvalidRouteException $e) {
			throw new NotFoundHttpException('Страница не найдена');
		} catch (Exception $e) {
			throw new NotFoundHttpException('Страница не найдена');
		}
	}

	/**
	 * Импорт товаров из csv файла
	 */
	public function importCSV()
	{
		$path_to_file = 'https://raw.githubusercontent.com/hflabs/city/master/city.csv';

		$data = ['add' => 0, 'error' => 0];
		if (($handle = fopen($path_to_file, 'rb')) !== false) {
			$i = 0;
			while (($row = fgetcsv($handle, 1000, ',')) !== false) {
				if ($i === 0) {
					$i++;
					continue;
				}
				$model = new City();
				$model->address = $row[0];
				$model->country = $row[2];
				$model->federal_district = $row[3];
				$model->region_type = $row[4];
				$model->region = $row[5];
				$model->area_type = $row[6];
				$model->area = $row[7];
				$model->city_type = $row[8];
				$model->city = $row[9];
				$model->timezone = $row[19];
				$model->geo_lat = $row[20];
				$model->geo_lon = $row[21];
				if ($model->validate()) {
					$model->save();
					$data['add']++;
				} else {
					$data['error']++;
				}
			}
			fclose($handle);
		}
		e($data);
	}


	public function insertRoutes(): void
	{
		$from = 510;
		$path_to_file = __DIR__.'/111.csv';

		$data = ['add' => 0, 'error' => 0];
		if (($handle = fopen($path_to_file, 'rb')) !== false) {
			while (($row = fgetcsv($handle, 1000, ';')) !== false) {
				foreach (array_chunk($row, 13) as $item) {
					$model = new Route();
					$to = str_replace(array("\r","\n"),"",$item[0]);
					$model->setAttributes([
						'from' => $from,
						'to' => $to,
						'refrigerator' => 0,
						'w500' => $item[1],
						'w1000' => $item[2],
						'w2000' => $item[3],
						'w3000' => $item[4],
						'w4000' => $item[5],
						'w5000' => $item[6],
						'v1' => $item[7],
						'v3' => $item[8],
						'v5' => $item[9],
						'v10' => $item[10],
						'v20' => $item[11],
						'v30' => $item[12],
					]);
					if ($model->validate()) {
						$model->save();
						$data['add']++;
					} else {
						$data['error']++;
					}
				}
			}
			fclose($handle);
		}
		e($data);
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}

		$model->password = '';
		return $this->renderPartial('login', [
			'model' => $model,
		]);
	}

	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	/**
	 * Displays contact page.
	 *
	 * @return Response|string
	 */
	public function actionContacts()
	{
		return $this->render('contacts');
	}

	/**
	 * Displays about page.
	 *
	 * @return string
	 */
	public function actionAbout()
	{
		return $this->render('about');
	}

	public function actionDocuments()
	{
		return $this->render('documents');
	}

	/**
	 * @param $filename
	 * @return string
	 */
	public function actionDownload($filename): string
	{
		$file = Yii::getAlias("@docs/$filename");
		Yii::$app->response->headers->set('Content-Type','application/vnd.ms-office');
		return Yii::$app->response->sendFile($file);
	}
}
