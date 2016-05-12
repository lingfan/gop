<?php
namespace VGPM\Model;

use VGPM\Lib\Common;

class ServerList {
	static $status = [
		0 => '正常',
		1 => '新开',
		2 => '火爆',
		3 => '维护',

	];

	/**
	 * @return \VGPM\DB\ServerList
	 */
	static public function getDB() {
		return Common::DB('ServerList');
	}

}

?>