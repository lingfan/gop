<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

class LogAction {
	/**
	 * @return \VGPM\DB\LogAction
	 */
	static public function getDB() {
		return Common::DB('LogAction');
	}
}

?>