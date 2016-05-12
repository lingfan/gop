<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

class UserGroup {
	/**
	 * @return \VGPM\DB\UserGroup
	 */
	static public function getDB() {
		return Common::DB('UserGroup');
	}
}

?>