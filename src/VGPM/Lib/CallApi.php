<?php
namespace VGPM\Lib;

class CallApi {
	var $callback = false;

	function setCallback($func_name) {
		$this->callback = $func_name;
	}

	function doRequest($method, $url, $vars) {
		if (empty($url)) {
			return false;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);//设置超时时间30秒
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		}
		$data = curl_exec($ch);
		curl_close($ch);
		if ($data) {
			if ($this->callback) {
				$callback       = $this->callback;
				$this->callback = false;
				return call_user_func($callback, $data);
			} else {

				return $data;
			}
		} else {
			ob_start();
			curl_error($ch);
			$msg = ob_get_contents();
			ob_clean();
			Logger::error(array(func_get_args(), $msg));
			return false;
		}
	}

	function get($url) {
		return $this->doRequest('GET', $url, 'NULL');
	}

	function post($url, $vars) {
		return $this->doRequest('POST', $url, $vars);
	}
}

?>