<?php
namespace VGPM\Lib;

/**
 *
 * 视图类
 * @author 胡威
 *
 */
class View {
	static $pageData = array();

	/**
	 *
	 * 呈现布局模板
	 *
	 * @param string $file
	 */
	static public function render($file, $data = []) {
		$content = self::load($file,$data);
		include(VIEW_PATH . '/layout.php');
		exit;
	}

	/**
	 *
	 * 呈现局部模板
	 *
	 * @param string $file
	 */
	static public function renderPartail($file) {
		echo self::load($file);
		exit;
	}

	/**
	 *
	 * 传递视图模板变量
	 *
	 * @param string $name
	 * @param        string /array $value
	 */
	static public function setVal($name, $value) {
		self::$pageData[$name] = $value;
	}

	/**
	 *
	 * 获取视图模板变量
	 *
	 * @param string $name
	 */
	static public function getVal($name) {
		return isset(self::$pageData[$name]) ? self::$pageData[$name] : '';
	}

	/**
	 *
	 * 加载局部模板
	 *
	 * @param string $file
	 */
	static public function load($file,$data=[]) {
		$viewFile = VIEW_PATH . '/' . $file . '.php';
		if (is_readable($viewFile)) {
			ob_start();
			if (!empty($data)) {
				foreach ($data as $key => $val) {
					self::setVal($key, $val);
				}
			}

			if (!empty(self::$pageData)) {
				extract(self::$pageData);
			}
			include($viewFile);
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		} else {
			new VException("{$viewFile} 模板文件不存在");
		}

	}

	static public function getData($file) {
		$viewDataFile = VIEW_PATH . '/' . $file . '.php';
		$viewData     = require_once $viewDataFile;
		return $viewData;
	}

	static public function layout() {

	}
}