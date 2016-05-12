<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

/**
 *
 */
class Mail {
	/**
	 * @return \VGPM\DB\Mail
	 */
	static public function getDB() {
		return Common::DB('Mail');
	}

}