<?php
namespace VGPM\Lib;

use VGPM\Model\ServerList;

class VgClient {
	static public function call($sid, $cmd, $data = []) {
		$sInfo = ServerList::getDB()->getBy(['no' => $sid]);
		if (empty($sInfo['host']) || empty($sInfo['port'])) {
			Logger::error([$sid, $sInfo]);
			return false;
		}

		$client = new \swoole_client(SWOOLE_SOCK_TCP);
		$client->set(array(
			'open_length_check'     => true,
			'package_length_type'   => 'n',
			'package_length_offset' => 0,       //第N个字节是包长度的值
			'package_body_offset'   => 2,       //第几个字节开始计算长度
			'package_max_length'    => 2000000,  //协议最大长度
		));

		if (!$client->connect($sInfo['host'], $sInfo['port'])) {
			return false;
		}

		$reqData  = ['type' => 'api', 'cmd' => $cmd, 'data' => $data];
		$sendStr  = json_encode($reqData);
		$sendData = pack('n', strlen($sendStr)) . $sendStr;
		$ret   = $client->send($sendData);
		//$resp  = $client->recv();
		//$data2 = substr($resp, 2);
		Logger::debug(['send', $sendData]);

		$client->close();
		return true;
	}
}