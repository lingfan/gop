<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

class Consumer {
	/**
	 * @return \VGPM\DB\Consumer
	 */
	static public function getDB() {
		return Common::DB('Consumer');
	}


}

?>