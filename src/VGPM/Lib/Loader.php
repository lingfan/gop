<?php
namespace VGPM\Lib;

/**
 * Class Loader
 * @package VGPM\Com
 */
class Loader {
	static $files;
	/**
	 *
	 */
	protected static $namespaces;


	/**
	 *
	 * @param $class
	 */
	static function autoload($class) {
		$file = SRC_PATH . '/' . str_replace('\\', '/', $class) . '.php';
		if (is_readable($file)) {
			require_once $file;
		} else {
			throw new \Exception("Loader FAIL#" . $file . PHP_EOL);
		}

	}

}