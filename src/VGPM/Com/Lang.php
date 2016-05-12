<?php
namespace VGPM\Com;

class Lang {
	/** 切换语言版本方法 */
	static public function T($name) {
		$arrLang = self::$lang_zh;    //选择语言版本
		return isset($arrLang[$name]) ? $arrLang[$name] : $name;
	}

	/** 中文版 */
	static $lang_zh = array();

	/** 英语版 */
	static $lang_en = array(
		'主菜单' => 'Main Menu',
	);


}

?>