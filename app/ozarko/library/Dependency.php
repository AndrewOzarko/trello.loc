<?php
namespace ozarko\library;

class Dependency {
	private $container;
	
	/**
	* Конструктор
	*/
	public function __construct() {
		$this->container[] = array();
	}

	/**
	* Getter
	*/
	public function get($key) {
		return $this->getByValue($key);
	}

	/**
	* Магічний метод, який спрощує життя
	*/
	public function __get($key) {
		return $this->getByValue($key);
	}

	/**
	* Setter
	*/
	public function set($key, $value){
		$this->container[$key] = $value;
	}

	/**
	* Для не дублювання коду
	*/
	private function getByValue($key){
		$result = null;
		if(!empty($this->container[$key])) {
			$result = $this->container[$key];
		}
		return $result;
	}
}