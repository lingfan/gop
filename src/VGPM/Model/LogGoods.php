<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

class LogGoods {
	/**
	 * @return \VGPM\DB\LogGoods
	 */
	static public function getDB() {
		return Common::DB('LogGoods');
	}
}

?>