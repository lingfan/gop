<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

/**
 *
 */
class NoticeMsg {
	/**
	 * @return \VGPM\DB\NoticeMsg
	 */
	static public function getDB() {
		return Common::DB('NoticeMsg');
	}

}