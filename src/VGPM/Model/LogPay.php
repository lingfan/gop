<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

class LogPay {
	/**
	 * @return \VGPM\DB\LogPay
	 */
	static public function getDB() {
		return Common::DB('LogPay');
	}
}

?>