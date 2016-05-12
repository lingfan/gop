<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

class LogOnline {
	/**
	 * @return  \VGPM\DB\LogOnline
	 */
	static public function getDB() {
		return Common::DB('LogOnline');
	}



}

?>