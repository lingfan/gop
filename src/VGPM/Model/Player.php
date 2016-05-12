<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

/**
 *
 */
class Player {
	/**
	 * @return \VGPM\DB\Player
	 */
	static public function getDB() {
		return Common::DB('Player');
	}

}