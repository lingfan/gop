<?php
namespace VGPM\DB;

use VGPM\Lib\DB;

class LogPay extends DB {
	protected $_name    = 'log_pay';
	protected $_primary = 'id';

	public function listLogByDate($start, $limit, $params) {
		$where = $this->sqlWhere($params);
		$sql   = sprintf('SELECT `date`, SUM(amount) as total_amount, SUM(num) as total_num, COUNT(DISTINCT `player_id`) as total_people, COUNT(`id`) as total_times FROM log_pay where %s group by `date` order by `date` desc LIMIT %s,%s', $where, $start, $limit);
		$list  = $this->fetchAll($sql);
		return $list;
	}

	public function totalLogByDate($params) {
		$where = $this->sqlWhere($params);
		$sql   = sprintf('SELECT COUNT(DISTINCT `date`) FROM log_pay where %s', $where);
		return $this->fetchCloum($sql, 0);
	}

	public function totalByGid($date, $sid) {
		$sql = sprintf('SELECT COUNT(DISTINCT `player_id`) FROM log_pay WHERE `date`=%s AND `server_id`=%s', $date, $sid);
		return $this->fetchCloum($sql, 0);
	}


	/**
	 * 新增付费用户
	 * @param $date
	 * @param $sid
	 *
	 * @return array
	 */
	public function totalNewPayUser($date, $sid) {
		$ret = [];
		$sql   = sprintf('SELECT `player_id` FROM log_pay WHERE `date`=%s AND `server_id`=%s GROUP BY `player_id`', $date, $sid);
		$list  = $this->fetchAll($sql);
		foreach ($list as $val) {
			$sql2 = sprintf('SELECT count(*) FROM log_pay WHERE `date`<%s AND `player_id`=%s ', $date, $val['player_id']);
			$n    = $this->fetchCloum($sql2, 0);
			if ($n == 0) {
				$ret[] = $val['player_id'];
			}
		}
		return $ret;
	}

	public function totalKeepUser($date,$sid) {
		$sql   = sprintf('SELECT `player_id` FROM %s WHERE `date`=%s AND `server_id`=%s GROUP BY `player_id`',$this->_name, $date, $sid);
		$list  = $this->fetchAll($sql);
		$ret = [];
		foreach($list as $val) {
			$ret[] = $val['player_id'];
		}
		return $ret;
	}


}

?>