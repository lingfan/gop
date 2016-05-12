<?php
namespace VGPM\Cmd;

use VGPM\Lib\View;
use VGPM\Model;

class PayLog extends Base {
	public function ADayLog() {
		View::render('PayLog/DayLog');
	}

	public function ADayLogList() {
		$page     = intval($this->postParam('page'));
		$pagesize = max(intval($this->postParam('pagesize')), 20);
		$start    = (max($page, 1) - 1) * $pagesize;
		$where    = $this->where();

		$total = Model\LogPay::getDB()->totalLogByDate($where);
		$list  = Model\LogPay::getDB()->listLogByDate($start, $pagesize, $where);
		foreach ($list as $k => $row) {
			$list[$k]['date']         = date('Y/m/d', strtotime($row['date']));
			$list[$k]['total_amount'] = sprintf("%.2f", $row['total_amount']);
			$list[$k]['arpu']         = sprintf("%.2f", $row['total_amount'] / $row['total_people']);
		}

		$this->outGrid($total, $list);
	}

	public function AUserLog() {
		View::render('PayLog/UserLog');
	}

	public function AUserLogList() {
		$page     = intval($this->postParam('page'));
		$pagesize = max(intval($this->postParam('pagesize')), 20);
		$start    = (max($page, 1) - 1) * $pagesize;
		$where    = $this->where();

		$where['status'] = 1;
		$total = Model\LogPay::getDB()->count($where);
		$list  = Model\LogPay::getDB()->getList($start, $pagesize, $where, ['id' => 'desc']);
		foreach ($list as $k => $row) {
			$list[$k]['status'] = $row['status'] == 1 ? '已支付' : '未支付';
		}

		$this->outGrid($total, $list);
	}


}

