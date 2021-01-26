<?php

namespace app\components;


use yii\base\Component;
use yii\helpers\Json;

/**
 * Class VueStore
 * @package app\components
 */
class VueStore extends Component
{
    private $state = [];
    private $getters = [];
    private $mutations = [];
    private $actions = [];

	/**
	 * @param string $key
	 * @param mixed $value
	 */
    public function pushState(string $key, $value): void
	{
        $this->state[$key] = $value;
    }

	/**
	 * @param array $states
	 */
    public function pushStates(array $states): void
	{
		foreach ($states as $key => $state) {
			$this->pushState($key, $state);
		}
	}

	/**
	 * @param string $key
	 * @param $value
	 */
    public function pushGetter(string $key, $value): void
    {
		$this->getters[$key] = $value;
    }

	/**
	 * @param string $key
	 * @param $value
	 */
    public function pushMutation(string $key, $value): void
    {
		$this->mutations[$key] = $value;
    }

	/**
	 * @param string $key
	 * @param $value
	 */
    public function pushAction(string $key, $value): void
    {
		$this->actions[$key] = $value;
    }

	/**
	 * @return string
	 */
    public function getStore(): string
	{
		$state = Json::encode($this->state);
		$gettets = $this->prepare('getters');
		$mutations = $this->prepare('mutations');
		$actions = $this->prepare('actions');
		return "{
    		state: $state,
    		getters: {{$gettets}}, 
    		mutations: {{$mutations}}, 
    		actions: {{$actions}}, 
    	}";
	}

    private function prepare($item): string
	{
		$res = '';
		foreach ($this->$item as $key => $value) {
			$res .= "$key: $value,";
		}
		return $res;
	}
}