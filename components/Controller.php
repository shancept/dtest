<?php


namespace app\components;


use app\models\Menu;
use app\models\Services;

/**
 *
 * @property-read mixed $menu
 * @property-read mixed $services
 */
class Controller extends \yii\web\Controller
{
	private $_menu;

	private $_services;

	public $menuColor = 'white';

	public function getMenu()
	{
		return $this->_menu ?? $this->_menu = Menu::getDb()->cache(function () {
				return Menu::find()->all();
			});
	}

	public function getServices()
	{
		return $this->_services ?? $this->_services = Services::getDb()->cache(function () {
				return Services::find()->indexBy('url')->orderBy('sort')->all();
			});
	}
}