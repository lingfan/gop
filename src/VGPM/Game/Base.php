<?php
namespace VGPM\Game;

class Base {
	private $_request = [];

	public function __construct() {

	}

	public function setRequest($data) {
		$this->_request = $data;
	}

	public function postParam($key) {
		$ret = filter_input(INPUT_POST, $key);
		return $ret;
	}

	public function getParam($key) {
		$ret = filter_input(INPUT_GET, $key);
		return $ret;
	}

	public function out($data = []) {
		header('Content-Type:application/json;charset=UTF-8');
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		exit;
	}


}