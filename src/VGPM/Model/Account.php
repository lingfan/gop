<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

/**
 *
 */
class Account {
	/**
	 * @return \VGPM\DB\Account
	 */
	static public function getDB() {
		return Common::DB('Account');
	}

}