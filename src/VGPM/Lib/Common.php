<?php
namespace VGPM\Lib;
use VGPM\DB;
/**
 *
 * 公共类库
 * @author 胡威
 *
 */
class Common {
	static public function redirect($url) {
		header('Location:' . $url);
		exit;
	}

	/**
	 *
	 * 返回结果控制
	 * @author huwei
	 *
	 * @param int   $flag 成功0 失败1 其他数字表示其他状态
	 * @param array $data 数据
	 *
	 * @return array
	 */
	static public function result(int $flag, array $data) {
		$ret = [];
		return $ret;

	}

	/**
	 *
	 * 返回数组转换成xml格式的结果
	 *
	 * @param array $data 数据
	 *
	 * @return string xml数据
	 */
	static public function outXml($arr) {
		$XmlConstruct = new Xml('data');
		$XmlConstruct->fromArray($arr);
		$XmlConstruct->output();
	}

	/**
	 * 转换字节单位
	 *
	 * @param int $size 数据
	 *
	 * @return string
	 */
	static public function convert($size) {
		$unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
		return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
	}


	static $_db = null;
	static $_rc = null;

	/**
	 * @param $name
	 *
	 * @return \VGPM\Lib\DB
	 */
	static public function DB($daoName) {
		if (empty(self::$_db[$daoName])) {
			$_daoName            = '\\VGPM\\DB\\' . $daoName;
			self::$_db[$daoName] = new $_daoName();
		}
		return self::$_db[$daoName];
	}


	/**
	 * @param $name
	 *
	 * @return DB
	 */
	static public function RC() {
		if (empty(self::$_rc)) {
			self::$_rc = new \VGPM\Lib\RC();
		}
		return self::$_rc;
	}

}