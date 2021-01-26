<?php
/**
 * Created by PhpStorm.
 * User: Shancept
 * Date: 12.05.19
 * Time: 15:13
 */

namespace app\modules\api\controllers;

use app\models\Seo;
use app\models\SeoData;
use app\models\SeoMeta;
use app\modules\api\components\Controller;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\HttpException;


class SeoController extends Controller
{
	public function behaviors(): array
	{
		$behaviors = parent::behaviors();
		$behaviors['access']['rules'] = [
			[
				'actions' => ['meta-tags', 'item', 'page-update', 'index', 'meta-data', 'site-map'],
				'allow' => true,
				'roles' => ['seo_manager'],
				'verbs' => ['GET', 'PUT', 'POST']
			]
		];
		return $behaviors;
	}

	/**
	 * @return string
	 */
	public function actionMetaTags()
	{
		$response = ['code' => 200];
		if ($this->request->isGet) {
			$response['response'] = SeoMeta::find()->all();
		}
		return Json::encode($response);
	}

	public function actionIndex()
	{
		$response = ['code' => 200];
		if ($this->request->isGet) {
			$response['response'] = Seo::find()
				->select([Seo::tableName().'.*'])
				->asArray()
				->joinWith('pageType', false)
				->all();
		}
		return Json::encode($response);
	}

	public function actionMetaData()
	{
		$response = ['code' => 200];
		if ($this->request->isGet) {
			$seo_id = $this->request->get('seo_id', false);
			$response['response'] = SeoData::find()
				->where(['seo_id' => $seo_id])
				->with('seoMeta')
				->asArray()
				->all();
		}
		return Json::encode($response);
	}

	public function actionItem($id)
	{
		$response = ['code' => 200];
		if (null === $page = Seo::findOne(['id' => $id])) {
			throw new HttpException(404, 'Станица не найдена');
		}
		if ($this->request->isPut) {
			$params = $this->request->put();
			$page->attributes = $params;
			$save = !!$page->save();
			if ($data = $params['seo-data']) {
				$data = Json::decode($data);
				SeoData::removeOld($page->id);
				SeoData::addAll($data);
			}
			$result = $save ? ['result' => 'success', 'item' => $page] : ['result' => 'error', 'errors' => $page->errors];
			$response['response'] = $result;
		}
		return Json::encode($response);
	}

	public function actionPageUpdate()
	{
		$pages = Pages::findAll(['active' => true]);
		$articles = Articles::findAll(['active' => true]);
		$portfolio = Portfolio::findAll(['active' => true]);

		foreach ($pages as $page) {
			$page_type_id = PageTypes::find()->where(['name' => 'pages'])->one()['id'];
			if (Seo::find()->where(['url' => $page['chpu']])->one() === null) {
				$seo = new Seo();
				$seo->url = $page['chpu'];
				$seo->title = $page['name'];
				$seo->h1 = $page['name'];
				$seo->page_type_id = $page_type_id;
				$seo->save();
			}
		}

		foreach ($articles as $article) {
			$page_type_id = PageTypes::find()->where(['name' => 'articles'])->one()['id'];
			if (Seo::find()->where(['url' => $article['chpu']])->one() === null) {
				$seo = new Seo();
				$seo->url = 'articles/'.$article['chpu'];
				$seo->title = $article['name'];
				$seo->h1 = $article['name'];
				$seo->page_type_id = $page_type_id;
				$seo->save();
			}
		}

		foreach ($portfolio as $item) {
			$page_type_id = PageTypes::find()->where(['name' => 'portfolio'])->one()['id'];
			if (Seo::find()->where(['url' => $item['chpu']])->one() === null) {
				$seo = new Seo();
				$seo->url = 'portfolio/'.$item['chpu'];
				$seo->title = $item['name'];
				$seo->h1 = $item['name'];
				$seo->page_type_id = $page_type_id;
				$seo->save();
			}
		}
	}

	public function actionSiteMap()
	{
		$begin = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		$end = '</urlset>';
		$string = '';

		$pages = Pages::findAll(['active' => true]);
		$articles = Articles::findAll(['active' => true]);
		$portfolio = Portfolio::findAll(['active' => true]);

		foreach ($pages as $elem) {
			$string .= '<url><loc>'.Url::to(['/'.$elem->chpu], true).'</loc><priority>0.9</priority></url>';
		}

		foreach ($articles as $elem) {
			$string .= '<url><loc>'.Url::to(['/'.$elem->chpu], true).'</loc><priority>0.9</priority></url>';
		}

		foreach ($portfolio as $elem) {
			$string .= '<url><loc>'.Url::to(['/'.$elem->chpu], true).'</loc><priority>0.9</priority></url>';
		}

		$site_map = $begin.$string.$end;

		$file_name = \Yii::$app->basePath.'/web/sitemap.xml';
		$fp = fopen($file_name, 'wb');
		fwrite($fp, $site_map);
		fclose($fp);
	}

}