<?php
namespace VGPM\Api;

use VGPM\Lib\Logger;
use VGPM\Model;

class Player extends Base {

	public function AInfo() {
		$username = $this->getParam('username');
		$token    = $this->getParam('token');
		$sid      = $this->getParam('server_id');
		$cid      = $this->getParam('consumer_id');
		$ip       = $this->getParam('ip');

		Logger::debug([$username, $sid, $cid]);
		if (empty($username) || empty($sid) || empty($cid)) {
			$this->out([]);
		}

		$info = Model\Player::getDB()->getBy(['username' => $username, 'server_id' => $sid]);
		if (empty($info)) {
			$addData = [
				'username'     => $username,
				'server_id'    => $sid,
				'consumer_id'  => $cid,
				'created_at'   => date('Y-m-d H:i:s'),
				'last_ip_addr' => $ip,
				'date'         => date('Ymd'),
			];
			$id      = Model\Player::getDB()->insert($addData);
			if ($id > 0) {
				$info       = $addData;
				$info['id'] = $id;
			}
		}

		$ret = [];
		if (!empty($info['id'])) {
			$ret = $info;
		}
		$this->out($ret);


	}

	public function ALogin() {

	}


}