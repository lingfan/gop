<?php
namespace VGPM\Cmd;

use VGPM\Lib\View;
use VGPM\Model;

class Server extends Base {
	public function AIndex() {
		View::render('Server/Index');
	}

	public function AEdit() {
		$id = intval($this->getParam('id'));
		if (!empty($this->postParam('host'))) {
			$upData = [
				'no'     => $this->postParam('no'),
				'host'   => $this->postParam('host'),
				'port'   => $this->postParam('port'),
				'name'   => $this->postParam('name'),
				'sort'   => $this->postParam('sort'),
				'status' => $this->postParam('status'),
			];
			if (empty($this->postParam('id'))) {
				$tmp = Model\ServerList::getDB()->getBy(['no'=>$upData['no']]);
				if (!empty($tmp['id'])) {
					$this->outMsg(1, '服务器编号已存在');
				}

				Model\ServerList::getDB()->insert($upData);
			} else {
				Model\ServerList::getDB()->update($upData, $this->postParam('id'));
			}
			$this->outMsg(0, '成功');
		}

		$data = ['info' => []];
		if (!empty($id)) {
			$data['info'] = Model\ServerList::getDB()->get($id);
		}

		View::render('Server/Edit', $data);
	}

	public function AList() {
		$page     = intval($this->postParam('page'));
		$pagesize = intval($this->postParam('pagesize'));

		$list  = Model\ServerList::getDB()->getAll();
		$total = count($list);
		foreach ($list as $k => $v) {
			$list[$k]['status'] = Model\ServerList::$status[$v['status']];

		}
		$this->outGrid($total, $list);
	}

	public function ADel() {
		$id = intval($this->getParam('id'));
		Model\ServerList::getDB()->delete($id);
		$this->outMsg(0, '成功');
	}


	public function AComboBox() {
		$all = intval($this->getParam('all'));
		$ret = [];
		if ($all) {
			$ret[] = ['text' => '全部', 'id' => 0];
		}
		$list = Model\ServerList::getDB()->getAll();
		foreach ($list as $val) {
			$ret[] = ['text' => 'S'.$val['no'], 'id' => $val['no']];
		}
		$this->out($ret);
	}

	public function ARadioList() {
		$ret = [];
		foreach (Model\ServerList::$status as $k => $v) {
			$ret[] = ['id' => $k, 'text' => $v];
		}
		$this->out($ret);
	}


}

