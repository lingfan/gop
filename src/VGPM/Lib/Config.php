<?php
namespace VGPM\Lib;

class Config {
	static private $_conf = null;

	static public function get($name) {
		if (empty(self::$_conf)) {
			$file = CONFIG_PATH . '/config.php';
			if (is_readable($file)) {
				self::$_conf = require $file;
			} else {
				Logger::halt("don't found config file");
			}
		}

		$ret = isset(self::$_conf[$name]) ? self::$_conf[$name] : array();
		return $ret;
	}


}