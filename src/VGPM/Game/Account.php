<?php
namespace VGPM\Game;

use VGPM\Model;

class Account extends Base {
	public function ARun() {

		$_uid = $this->getParam('uid');
		$_pwd = $this->getParam('passwordId');
		$info = Model\Account::getDB()->getBy(['username' => $_uid]);

		$flag = false;
		if (empty($info['id'])) {
			$add = [
				'username'   => $_uid,
				'password'   => md5($_pwd),
				'created_at' => date('Y-m-d H:i:s'),
			];
			Model\Account::getDB()->insert($add);
			$flag = true;
		} else if ($info['password'] == md5($_pwd)) {
			$flag = true;
		}
		$flag = true;

		if ($flag) {
			$ret = [
				'code'       => 0,
				'msg'        => 'ok',
				'uid'        => $_uid,
				'passwordId' => $_pwd,
				'token'      => $this->_crc($_uid),
			];
		} else {
			$ret = [
				'code' => 1,
				'msg'  => '密码错误',
			];
		}

		$this->out($ret);
	}

	private function _crc($id) {
		$t = time();
		return $t . crc32($id . $t . '123456');
	}


}