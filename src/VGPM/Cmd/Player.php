<?php
namespace VGPM\Cmd;

use VGPM\Lib\View;
use VGPM\Model;

class Player extends Base {

	public function AIndex() {
		View::render('Player/Index');
	}

	public function AList() {
		$page     = intval($this->postParam('page'));
		$pagesize = max(intval($this->postParam('pagesize')), 20);
		$start    = (max($page, 1) - 1) * $pagesize;
		$where    = $this->where();

		$total = Model\Player::getDB()->count($where);
		$list  = Model\Player::getDB()->getList($start, $pagesize, $where, ['id' => 'desc']);
		foreach ($list as $k => $row) {
		}

		$this->outGrid($total, $list);
	}
}

?>