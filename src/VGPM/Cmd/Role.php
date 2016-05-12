<?php
namespace VGPM\Cmd;

use VGPM\Lib\View;
use VGPM\Model;

class Role extends Base {
	public function AGoodsUseLog() {
		View::render('Role/GoodsUseLog');
	}

	public function ALoginHistory() {
		View::render('Role/LoginHistory');
	}


	public function AGoodsUseLogList() {
		$page     = intval($this->postParam('page'));
		$pagesize = max(intval($this->postParam('pagesize')), 20);
		$start    = (max($page, 1) - 1) * $pagesize;
		$where    = $this->where();

		$total = Model\LogGoods::getDB()->count($where);
		$list  = Model\LogGoods::getDB()->getList($start, $pagesize, $where, ['id' => 'desc']);
		foreach ($list as $k => $row) {
			//$list[$k]['created_at'] = date('Y/m/d H:i:s', $row['created_at']);
		}

		$this->outGrid($total, $list);
	}

	public function ALoginHistoryList() {
		$page     = intval($this->postParam('page'));
		$pagesize = max(intval($this->postParam('pagesize')), 20);
		$start    = (max($page, 1) - 1) * $pagesize;
		$where    = $this->where();


		$total = Model\LogLogin::getDB()->count($where);
		$list  = Model\LogLogin::getDB()->getList($start, $pagesize, $where, ['id' => 'desc']);

		foreach ($list as $k => $row) {
		}

		$this->outGrid($total, $list);
	}


	public function ALogAction() {
		View::render('Role/LogAction');
	}

	public function ALogActionList() {
		$page     = intval($this->postParam('page'));
		$pagesize = max(intval($this->postParam('pagesize')), 20);
		$start    = (max($page, 1) - 1) * $pagesize;
		$where    = $this->where();

		$total = Model\LogAction::getDB()->count($where);
		$list  = Model\LogAction::getDB()->getList($start, $pagesize, $where, ['id' => 'desc']);
		foreach ($list as $k => $row) {

		}

		$this->outGrid($total, $list);
	}

	public function ALogPacket() {
		View::render('Role/LogPacket');
	}

	public function ALogPacketList() {
		$page     = intval($this->postParam('page'));
		$pagesize = max(intval($this->postParam('pagesize')), 20);
		$start    = (max($page, 1) - 1) * $pagesize;
		$where    = $this->where();


		$roleId = $this->postParam('role_id');
		if ($roleId) {
			$where['role_id'] = $roleId;
		}

		$total = Model\LogPacket::getDB()->count($where);
		$list  = Model\LogPacket::getDB()->getList($start, $pagesize, $where, ['id' => 'desc']);
		foreach ($list as $k => $row) {

		}

		$this->outGrid($total, $list);
	}

}