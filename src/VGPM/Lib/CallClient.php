<?php
namespace VGPM\Lib;

class CallClient {
	private $_client = null;

	public function __construct($ip = '0.0.0.1', $port = 8080) {
		$this->_client = new \swoole_client(SWOOLE_SOCK_TCP);

		$this->_client->set(array(
			'open_length_check'     => true,
			'package_length_type'   => 'n',
			'package_length_offset' => 0,       //第N个字节是包长度的值
			'package_body_offset'   => 2,       //第几个字节开始计算长度
			'package_max_length'    => 2000000,  //协议最大长度
		));
		if (!$this->_client->connect($ip, $port)) {
			exit("connect failed\n");
		}
	}

	function send($data) {
		return $this->_client->send($data);
	}

	function recv() {
		return $this->_client->recv();
	}

	function close() {
		return $this->_client->close();
	}
}

?>