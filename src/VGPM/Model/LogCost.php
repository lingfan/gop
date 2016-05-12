<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

class LogCost {
	/**
	 * @return \VGPM\DB\LogCost
	 */
	static public function getDB() {
		return Common::DB('LogCost');
	}
}

?>