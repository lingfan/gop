<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

/**
 *
 */
class NoticeLogin {
	/**
	 * @return \VGPM\DB\NoticeLogin
	 */
	static public function getDB() {
		return Common::DB('NoticeLogin');
	}

}