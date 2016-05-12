<?php
namespace VGPM\Cmd;

use VGPM\Lib\Common;
use VGPM\Lib\View;
use VGPM\Model;


class User extends Base {
	public function AIndex() {
		View::render('User/Index');
	}

	public function AGroup() {
		View::render('User/Group');
	}

	public function AEdit() {
		$id = intval($this->getParam('id'));
		if (!empty($this->postParam('username'))) {
			$upData = [
				'username'     => $this->postParam('username'),
				'nickname'     => $this->postParam('nickname'),
				'group_id'     => $this->postParam('group_id'),
				'consumer_ids' => $this->postParam('consumer_ids'),
			];

			$password = $this->postParam('password');
			if (!empty($password)) {
				$upData['password'] = md5($password);
			}

			if (empty($this->postParam('id'))) {
				Model\User::getDB()->insert($upData);
			} else {
				Model\User::getDB()->update($upData, $this->postParam('id'));
			}
			$this->outMsg(0, '成功');
		}

		$data = ['info' => []];
		if (!empty($id)) {
			$data['info'] = Model\User::getDB()->get($id);
		}

		$tmp       = Model\UserGroup::getDB()->getsBy([]);
		$groupList = [];
		foreach ($tmp as $v) {
			$groupList[] = ['id' => $v['id'], 'text' => $v['name']];
		}

		$tmp           = Model\Consumer::getDB()->getsBy([]);
		$consumer_list = [];
		foreach ($tmp as $v) {
			$consumer_list[] = ['id' => $v['id'], 'text' => $v['name']];
		}

		$data['group_list']    = $groupList;
		$data['consumer_list'] = $consumer_list;
		View::render('User/Edit', $data);
	}

	public function AList() {
		$page     = intval($this->postParam('page'));
		$pagesize = intval($this->postParam('pagesize'));
		$start    = (max($page, 1) - 1) * $pagesize;
		$total    = Model\User::getDB()->count();
		$list     = Model\User::getDB()->getList($start, $pagesize);

		$userGroupList = $ConsumerList = [];
		$tmp           = Model\UserGroup::getDB()->getsBy([]);
		foreach ($tmp as $val) {
			$userGroupList[$val['id']] = $val['name'];
		}
		$tmp = Model\Consumer::getDB()->getsBy([]);
		foreach ($tmp as $val) {
			$ConsumerList[$val['id']] = $val['name'];
		}

		foreach ($list as $k => $v) {
			$list[$k]['consumer_ids'] = isset($ConsumerList[$v['consumer_ids']]) ? $ConsumerList[$v['consumer_ids']] : '';
			$list[$k]['group_id']     = isset($userGroupList[$v['group_id']]) ? $userGroupList[$v['group_id']] : '';
		}

		$this->outGrid($total, $list);
	}

	public function ATest() {
		View::renderPartail('User/test');
	}


	public function AGroupEdit() {
		$id = intval($this->getParam('id'));

		if (!empty($this->postParam('name'))) {
			$upData = [
				'name' => $this->postParam('name'),
				'flag' => $this->postParam('flag'),
			];

			if (empty($this->postParam('id'))) {
				Common::DB('UserGroup')->insert($upData);
			} else {
				Common::DB('UserGroup')->update($upData, $this->postParam('id'));
			}

			$this->outMsg(0, '成功');
		}

		$data = ['info' => []];
		if (!empty($id)) {
			$data['info'] = Common::DB('UserGroup')->get($id);
		}

		View::render('User/GroupEdit', $data);
	}

	public function AGroupList() {
		$page     = intval($this->postParam('page'));
		$pagesize = intval($this->postParam('pagesize'));

		$total    = Common::DB('UserGroup')->count();
		$pagesize = $total;
		$start    = (max($page, 1) - 1) * $pagesize;
		$list     = Common::DB('UserGroup')->getList($start, $pagesize);

		$this->outGrid($total, $list);
	}

	public function ADel() {
		$id = intval($this->getParam('id'));
		Model\User::getDB()->delete($id);
		$this->outMsg(0, '成功');
	}

	public function AGroupDel() {
		$id = intval($this->getParam('id'));
		Common::DB('UserGroup')->delete($id);
		$this->outMsg(0, '成功');
	}
}