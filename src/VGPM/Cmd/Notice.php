<?php
namespace VGPM\Cmd;

use VGPM\Com\App;
use VGPM\Lib\View;
use VGPM\Model;

class Notice extends Base {

	public function ALogin() {
		View::render('Notice/Login');
	}

	public function ALoginList() {
		$page     = intval($this->postParam('page'));
		$pagesize = intval($this->postParam('pagesize'));
		$start    = (max($page, 1) - 1) * $pagesize;
		$total    = Model\NoticeLogin::getDB()->count();
		$list     = Model\NoticeLogin::getDB()->getList($start, $pagesize);

		foreach ($list as $k => $v) {
			$list[$k]['s_time'] = date('Y/m/d H:i:s',$v['s_time']);
			$list[$k]['e_time'] = date('Y/m/d H:i:s',$v['e_time']);
			$list[$k]['status'] = App::$status[$v['status']];
			$list[$k]['updated_at'] = date('Y/m/d H:i:s',$v['updated_at']);
		}

		$this->outGrid($total, $list);
	}

	public function ALoginEdit() {
		$id = intval($this->getParam('id'));
		if (!empty($this->postParam('content'))) {
			$upData = [
					's_time'     => strtotime($this->postParam('s_time')),
					'e_time'     => strtotime($this->postParam('e_time')),
					'uid'        => 1,
					'content'    => $this->postParam('content'),
					'status'     => $this->postParam('status'),
					'sort'       => $this->postParam('sort'),
					'server_ids' => $this->postParam('server_ids'),
			];
			$upData['updated_at'] = time();
			if (empty($this->postParam('id'))) {
				$upData['created_at'] = time();
				$ret = Model\NoticeLogin::getDB()->insert($upData);
			} else {
				$ret = Model\NoticeLogin::getDB()->update($upData, $this->postParam('id'));
			}

			if ($ret) {
				$this->outMsg(0, '成功');
			} else {
				$this->outMsg(1, '失败');
			}
		}

		$data = ['info' => []];
		if (!empty($id)) {
			$data['info'] = Model\NoticeLogin::getDB()->get($id);
		}

		View::render('Notice/LoginEdit', $data);
	}

	public function ALoginDel() {
		$id = intval($this->getParam('id'));
		Model\NoticeLogin::getDB()->delete($id);
		$this->outMsg(0, '成功');
	}


	public function AMsg() {
		View::render('Notice/Msg');
	}

	public function AMsgList() {
		$page     = intval($this->postParam('page'));
		$pagesize = intval($this->postParam('pagesize'));
		$start    = (max($page, 1) - 1) * $pagesize;
		$total    = Model\NoticeMsg::getDB()->count();
		$list     = Model\NoticeMsg::getDB()->getList($start, $pagesize);

		foreach ($list as $k => $v) {
			$list[$k]['s_time'] = date('Y/m/d H:i:s',$v['s_time']);
			$list[$k]['e_time'] = date('Y/m/d H:i:s',$v['e_time']);
			$list[$k]['status'] = App::$status[$v['status']];
			$list[$k]['updated_at'] = date('Y/m/d H:i:s',$v['updated_at']);
		}

		$this->outGrid($total, $list);
	}

	public function AMsgEdit() {
		$id = intval($this->getParam('id'));
		if (!empty($this->postParam('content'))) {
			$upData = [
				's_time'     => strtotime($this->postParam('s_time')),
				'e_time'     => strtotime($this->postParam('e_time')),
				'uid'        => 1,
				'interval'   => $this->postParam('interval'),
				'content'    => $this->postParam('content'),
				'status'     => $this->postParam('status'),
				'sort'       => $this->postParam('sort'),
				'server_ids' => $this->postParam('server_ids'),
			];
			$upData['updated_at'] = time();
			if (empty($this->postParam('id'))) {
				$upData['created_at'] = time();
				$ret = Model\NoticeMsg::getDB()->insert($upData);
			} else {
				$ret = Model\NoticeMsg::getDB()->update($upData, $this->postParam('id'));
			}

			if ($ret) {
				$this->outMsg(0, '成功');
			} else {
				$this->outMsg(1, '失败');
			}

		}

		$data = ['info' => []];
		if (!empty($id)) {
			$data['info'] = Model\NoticeMsg::getDB()->get($id);
		}

		View::render('Notice/MsgEdit', $data);
	}

	public function AMsgDel() {
		$id = intval($this->getParam('id'));
		Model\NoticeMsg::getDB()->delete($id);
		$this->outMsg(0, '成功');
	}
}