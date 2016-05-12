<?php
namespace VGPM\Cmd;

use VGPM\Lib\View;
use VGPM\Model;

class Consumer extends Base {
	public function AIndex() {
		View::render('Consumer/Index');
	}

	public function AEdit() {
		$id = intval($this->getParam('id'));
		if (!empty($this->postParam('name'))) {
			$upData = [
				'name'       => $this->postParam('name'),
				'code'       => $this->postParam('code'),
				'server_ids' => $this->postParam('server_ids'),
			];
			if (empty($this->postParam('id'))) {
				Model\Consumer::getDB()->insert($upData);
			} else {
				Model\Consumer::getDB()->update($upData, $this->postParam('id'));
			}
			$this->outMsg(0, '成功');
		}

		$data = ['info' => []];
		if (!empty($id)) {
			$data['info'] = Model\Consumer::getDB()->get($id);
		}

		View::render('Consumer/Edit', $data);
	}

	public function AList() {
		$page     = intval($this->postParam('page'));
		$pagesize = intval($this->postParam('pagesize'));
		$start    = (max($page, 1) - 1) * $pagesize;
		$total    = Model\Consumer::getDB()->count();
		$list     = Model\Consumer::getDB()->getList($start, $pagesize);

		foreach ($list as $k => $v) {
			$list[$k]['server_num'] = count(explode(';', $v['server_ids']));
		}

		$this->outGrid($total, $list);
	}

	public function ADel() {
		$id = intval($this->getParam('id'));
		Model\Consumer::getDB()->delete($id);
		$this->outMsg(0, '成功');
	}

	public function AComboBox() {
		$all = intval($this->getParam('all'));
		$ret = [];
		if ($all) {
			$ret[] = ['text' => '全部', 'id' => 0];
		}
		$list = Model\Consumer::getDB()->getAll();
		foreach ($list as $val) {
			$ret[] = ['text' => $val['name'], 'id' => $val['id']];
		}
		$this->out($ret);
	}
}

