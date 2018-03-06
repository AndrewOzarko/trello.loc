<?php
namespace ozarko\library;

abstract class Controller {
	protected $di;

	public function __construct($di) {
		$this->di = $di;
	}

	public abstract function indexAction();
}