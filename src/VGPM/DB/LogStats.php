<?php
namespace VGPM\DB;

use VGPM\Lib\DB;

class LogStats extends DB {
	protected $_name    = 'log_stats';
	protected $_primary = 'id';


	public function totals($params) {
		$where = $this->sqlWhere($params);
		if (!empty($params['server_id'])) {
			$sql = sprintf('SELECT `type`,`num` FROM %s WHERE %s ORDER BY `date` DESC', $this->_name, $where);
		} else {
			$sql = sprintf('SELECT `type`, SUM(num) as num FROM %s WHERE  %s GROUP BY `type` ORDER BY `date` DESC', $this->_name, $where);
		}
		$list = $this->fetchAll($sql);
		return $list;
	}

}

?>