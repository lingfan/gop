<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

class LogLogin {
	/**
	 * @return \VGPM\DB\LogLogin
	 */
	static public function getDB() {
		return Common::DB('LogLogin');
	}


}

?>