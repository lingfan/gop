<?php
namespace VGPM\Cmd;

use VGPM\Lib\View;
use VGPM\Model;

class Stats extends Base {
	public function ADay() {
		View::render('Stats/Day');
	}

	public function ADayList() {
		$sdate     = $this->postParam('sdate');
		$edate     = $this->postParam('edate');
		$server_id = $this->postParam('server_id');
		$sdate     = !empty($sdate) ? date('Ymd', strtotime($sdate)) : date('Ymd', time() - 30 * 86400);
		$edate     = !empty($edate) ? date('Ymd', strtotime($edate)) : date('Ymd');
		$where     = [];

		if ($server_id > 0) {
			$where['server_id'] = $server_id;
		}

		$s   = strtotime($sdate);
		$e   = strtotime($edate);
		$ret = [];
		for ($t = $s; $t <= $e; $t += 86400) {
			$d             = date('Ymd', $t);
			$where['date'] = $d;
			$list          = Model\LogStats::getDB()->totals($where);

			$tmp         = [];
			$tmp['date'] = date('Y/m/d', $t);
			foreach ($list as $k => $row) {
				$tmp[$row['type']] = $row['num'];
			}


			$tmp['pay_user_1']   = !empty($tmp['pay_user_new']) ? floor($tmp['pay_user_1'] / $tmp['pay_user_new'] * 100) . '%' : '';
			$tmp['pay_user_7']   = !empty($tmp['pay_user_new']) ? floor($tmp['pay_user_7'] / $tmp['pay_user_new'] * 100) . '%' : '';
			$tmp['pay_user_30']  = !empty($tmp['pay_user_new']) ? floor($tmp['pay_user_30'] / $tmp['pay_user_new'] * 100) . '%' : '';
			$tmp['keep_user_1']  = !empty($tmp['keep_user_new']) ? floor($tmp['keep_user_1'] / $tmp['keep_user_new'] * 100) . '%' : '';
			$tmp['keep_user_7']  = !empty($tmp['keep_user_new']) ? floor($tmp['keep_user_7'] / $tmp['keep_user_new'] * 100) . '%' : '';
			$tmp['keep_user_30'] = !empty($tmp['keep_user_new']) ? floor($tmp['keep_user_30'] / $tmp['keep_user_new'] * 100) . '%' : '';

			$ret[] = $tmp;
		}
		$this->outGrid(count($ret), $ret);
	}

	public function ACost() {
		View::render('Stats/Cost');
	}


	public function ACostList() {
		$page     = intval($this->postParam('page'));
		$pagesize = max(intval($this->postParam('pagesize')), 20);
		$start    = (max($page, 1) - 1) * $pagesize;
		$where    = $this->where();


		$total = Model\LogCost::getDB()->count($where);
		$list  = Model\LogCost::getDB()->getList($start, $pagesize, $where, ['created_at' => 'desc']);
		foreach ($list as $k => $row) {
			//$list[$k]['created_at'] = date('Y/m/d H:i:s', $row['created_at']);
		}

		$this->outGrid($total, $list);
	}

	public function ACostType() {
		View::render('Stats/CostType');
	}

	public function ACostTypeList() {
		$where    = $this->where();
		$list  = Model\LogCost::getDB()->getByType($where);
		$total = array_sum($list);
		$ret   = [];
		foreach ($list as $type => $num) {
			$ret[] = ['type' => $type, 'num' => $num, 'rate' => floor($num / $total * 100) . '%'];
		}

		$this->outGrid(count($ret), $ret);
	}


}

