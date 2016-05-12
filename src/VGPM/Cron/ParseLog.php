<?php
namespace VGPM\Cron;

use VGPM\Model;

class ParseLog {
	private $_logDir = '/data/agame_log';

	public function ARun() {
		$m   = date('Hi', strtotime("-2 minute"));
		$dir = $this->_logDir . '/' . date('Ymd') . '/' . $m . '/';
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					list($id, $type) = explode("_", $file);
					$this->_parseFile($dir . $file, $type);
				}
			}
			closedir($handle);
		}
	}

	private function _parseFile($filename, $type) {
		$lines = file($filename);
		foreach ($lines as $line) {
			$line = trim($line);
			if (!empty($line)) {
				$data = json_decode($line, true);
				$this->_addData($type, $data);
			}
		}
	}

	private function _addData($type, $data) {
		$id = 0;
		if (isset($data['gid'])) {
			$data['player_id'] = $data['gid'];
			unset($data['gid']);
		}

		if ($type == 'pay') {
			$id = Model\LogPay::getDB()->insert($data);
		} else if ($type == 'online') {
			$id = Model\LogOnline::getDB()->insert($data);
		} else if ($type == 'cost') {
			$id = Model\LogCost::getDB()->insert($data);
		} else if ($type == 'action') {
			$id = Model\LogAction::getDB()->insert($data);
		} else if ($type == 'login') {
			$id = Model\LogLogin::getDB()->insert($data);
		} else if ($type == 'goods') {
			$id = Model\LogGoods::getDB()->insert($data);
		} else if ($type == 'packet') {
			if (isset($data['created_at'])) {
				$data['data'] = json_encode($data['data'], JSON_UNESCAPED_UNICODE);

				$id = Model\LogPacket::getDB()->insert($data);
			}
		}

		echo $id . ':' . $type . '=>' . json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL;

	}

}