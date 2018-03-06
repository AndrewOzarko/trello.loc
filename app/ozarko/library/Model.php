<?php 
namespace ozarko\library;

abstract class Model {
	protected $db;

	public function __construct($di) {
		$this->db = $di->db;
	}
}