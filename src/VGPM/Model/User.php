<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

class User {
	/**
	 * @return \VGPM\DB\User
	 */
	static public function getDB() {
		return Common::DB('User');
	}
}

?>