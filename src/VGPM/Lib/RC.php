<?php
namespace VGPM\Lib;
/**
 * Class RC
 */
class RC {
	protected $cache;

	/**
	 * 构造函数
	 */
	public function __construct() {
		$redisConf = Config::get('db');
		try {
			$this->cache = new \Redis();
			$this->cache->connect($redisConf['host'], $redisConf['port']);
		} catch (Exception $e) {
			return false;
		}
	}

	public function setArr($key, $val) {
		$data = json_encode($val,JSON_UNESCAPED_UNICODE);
		return $this->cache->set($key, $data);
	}

	public function getArr($key) {
		$val  = $this->cache->get($key);
		$data = json_decode($val,true);
		return $data;
	}

	public function get($key) {
		return $this->cache->get($key);
	}

	public function set($key, $val, $ttl = 0) {
		if ($ttl > 0) {
			return $this->cache->set($key, $val, $ttl);
		}
		return $this->cache->set($key, $val);
	}

	public function del($key) {
		return $this->cache->del($key);
	}

	public function info() {
		return $this->cache->info();
	}

	public function keys($val) {
		return $this->cache->keys($val);
	}


	public function zIncrBy($key, $value, $member) {
		return $this->cache->zIncrBy($key, $value, $member);
	}

	public function zAdd($key, $score1, $value) {
		return $this->cache->zAdd($key, $score1, $value);
	}

	public function zRange($key, $start, $end, $withscores = false) {
		return $this->cache->zRange($key, $start, $end, $withscores);
	}

	public function zCard($key) {
		return $this->cache->zCard($key);
	}

}

?>