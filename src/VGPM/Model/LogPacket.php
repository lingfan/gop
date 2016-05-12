<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

class LogPacket {
	/**
	 * @return \VGPM\DB\LogPacket
	 */
	static public function getDB() {
		return Common::DB('LogPacket');
	}
}

?>