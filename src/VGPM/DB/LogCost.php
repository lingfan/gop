<?php
namespace VGPM\DB;

use VGPM\Lib\DB;

class LogCost extends DB {
	protected $_name    = 'log_cost';
	protected $_primary = 'id';

	public function getByType($params) {
		$where = $this->sqlWhere($params);
		$sql   = sprintf('SELECT SUM(`num`) as `num`,`type` FROM %s WHERE %s GROUP BY `type`', $this->_name, $where);
		$list  = $this->fetchAll($sql);
		$ret   = [];
		foreach ($list as $val) {
			$ret[$val['type']] = $val['num'];
		}
		return $ret;
	}

}

?>