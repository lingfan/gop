<?php

class ApiClient {
	/**
	 * api 客户端接口
	 *
	 * @param string $m
	 * @param string $a
	 * @param array  $params
	 */
	static public function Call($m, $a, $params = array(), $sid = 0) {
		if (!empty($m) && !empty($a) && is_array($params)) {
			if (empty($sid)) {
				$info   = MUser::getServerInfo();
				$apiurl = $info['server_url'];
				$key    = $info['server_key'];
			} else {
				$info   = MServerList::getAll($sid);
				$apiurl = $info['server_url'];
				$key    = $info['server_key'];
			}

			$s    = strtolower($m) . '|' . strtolower($a) . '|' . $key;
			$auth = md5($s);
			$args = array('r' => $m . '/' . $a, 'auth' => $auth, 'params' => json_encode($params));
			$a    = new CURL();
			$out  = $a->post($apiurl, $args);
			$ret  = $out;
			if (!empty($out)) {
				$data = json_decode($out, true);
				if ($data['ReturnFlag'] == 1) {
					$ret = array('Data' => $data['ReturnData'], 'Err' => '');
				} else if ($data['ReturnFlag'] == 2) {
					$ret = array('Data' => '', 'Err' => '数据返回格式错误', 'Debug' => $out);
				} else if ($data['ReturnFlag'] == 3) {
					$ret = array('Data' => '', 'Err' => '通讯KEY错误');
				}
			}
			return $ret;

		}

	}
}

class CURL {
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
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
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