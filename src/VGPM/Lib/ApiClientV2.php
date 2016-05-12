<?php

class ApiClientV2 {
	/**
	 * api 客户端接口
	 *
	 * @param string $m
	 * @param string $a
	 * @param array  $params
	 */
	static public function Call($m, $a, $params = array(), $sid = 0) {
		$ret = false;
		if (!empty($m) && !empty($a) && is_array($params)) {
			if (empty($sid)) {
				$sid = MUser::getServerId();
			}

			$info = MServerList::getAll($sid);
			if ($info) {
				$apiurl = $info['server_url'];
				//@todo api.php => api_v2.php
				$apiurl = str_replace('api.php', 'api_v2.php', $apiurl);

				$key  = $info['server_key'];
				$args = array(
					'm'      => $m,
					'a'      => $a,
					'auth'   => md5("{$m}|{$a}|{$key}"),
					'params' => json_encode($params)
				);

				$a   = new ApiCurl();
				$out = $a->post($apiurl, $args);
				$ret = $out;
			}
			return $ret;
		}
	}
}


?>