<?php
namespace VGPM\Cmd;

use VGPM\Lib\View;
use VGPM\Model;

class Online extends Base {
	public function AHour() {
		View::render('Online/Hour');
	}

	public function AHourList() {
		$date      = $this->postParam('date');
		$server_id = $this->postParam('server_id');

		$where['date'] = !empty($date) ? date('ymd', strtotime($date)) : date('ymd');

		if ($server_id > 0) {
			$where['server_id'] = $server_id;
		}

		//$total = Model\LogOnline::getDB()->totalByDate($where);
		$list = Model\LogOnline::getDB()->listByHour($where);

		$tmp = [];
		foreach ($list as $k => $row) {
			$list[$k]['date']  = date('Y/m/d', strtotime($row['date']));
			$tmp[$row['hour']] = $row;
		}

		$ret  = [];
		$start = mktime(0, 0);
		for ($i = 0; $i < 48; $i++) {
			$h      = date('Hi', $start + $i * 1800);


			if (empty($tmp[$h])) {
				$tmp[$h] = ['hour'=>$h,'num'=>0];
			}

			$tmp[$h]['hour'] = implode(':', str_split($tmp[$h]['hour'], 2));

			$ret[] =  $tmp[$h];
		}




		$this->outGrid(0, $ret);
	}


	public function ADay() {
		View::render('Online/Day');
	}


	public function ADayList() {

		$page     = intval($this->postParam('page'));
		$pagesize = max(intval($this->postParam('pagesize')), 20);
		$start    = (max($page, 1) - 1) * $pagesize;
		$where    = $this->where();


		$total = Model\LogOnline::getDB()->totalByDate($where);
		$list  = Model\LogOnline::getDB()->listByDate($start, $pagesize, $where);
		foreach ($list as $k => $row) {
			$list[$k]['date'] = date('Y/m/d', strtotime($row['date']));
			$list[$k]['avg']  = floor($row['avg']);
		}

		$this->outGrid($total, $list);
	}


	public function ANow() {
		View::render('Online/Now');
	}


	public function ANowList() {
		$server_id = $this->postParam('server_id');
		if ($server_id > 0) {
			$where['server_id'] = $server_id;
		}

		$total = 0;
		$list  = [];

		$this->outGrid($total, $list);
	}

}

