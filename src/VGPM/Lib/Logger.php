<?php
namespace VGPM\Lib;

/**
 * 程序逻辑日志
 */
class Logger {
	static public function error($msg) {
		return self::write($msg, 'error');
	}

	static public function debug($msg) {
		return self::write($msg, 'debug');
	}

	static public function warn($msg) {
		return self::write($msg, 'warn');
	}

	static public function write($msg, $type) {
		$msg  = json_encode($msg, JSON_UNESCAPED_UNICODE);
		$path = LOG_PATH . '/other/';

		if (!file_exists($path)) {
			@mkdir($path, 0777, true);
		}
		$logFile = $path . $type . '_' . date('Ymd') . '.log';
		$now     = date('Y-m-d H:i:s');
		$msg     = "[{$now}] {$msg} \n";
		error_log($msg, 3, $logFile);
		return true;
	}

	static public function dump($msg, $file) {
		error_log($msg, 3, $file);
	}

	static public function halt($msg) {
		die($msg);
	}

	/**
	 * @author huwei
	 *
	 * @param string $funcName 操作函数名
	 * @param string $errMsg   错误信息
	 * @param arr    $params   参数
	 */
	static public function dbwrite($funcName, $errMsg, $parms) {
		$parms   = json_encode($parms);
		$errMsg  = json_encode($errMsg);
		$path    = LOG_PATH . '/db/';
		$logFile = $path . date('Ymd') . '.log';
		$now     = date('Y-m-d H:i:s');
		$msg     = "[{$now}] [{$funcName}] [{$errMsg}] [{$parms}] \n";
		error_log($msg, 3, $logFile);
	}

}

?>