<?php
namespace VGPM\Model;

use VGPM\Lib\Common;
use VGPM\Model;

class LogStats {
	/**
	 *
	 *
	 * 新增用户：统计周期内，有新安装行为的独立用户数，单位人；
	 * 日活跃用户：统计周期内，有新安装或者登录行为的独立用户数，单位人；
	 * 同时在线：服务器每隔5分钟向缓存输出一个在线统计值，在该统计点最近30分钟内有过一次操作的用户为在线用户，同一统计点的在线用户数为同时在线，单位人；
	 * 最高在线：统计日期当天，所有统计点的同时在线用户数最大值，单位人；
	 * 平均在线：统计日期当天，所有统计点同时在线用户数的平均值，单位人；
	 * 付费用户：统计日期当天，至少有1次付费行为的玩家数量，单位人；
	 * 新增付费用户：统计日期当天，首次有付费行为的玩家数量，单位人；
	 * N天留存率：统计日期当天注册且第N天仍然活跃的独立用户数量/统计日期当天注册的用户总数，单位%；
	 * N日付费率：统计日期当天注册且第N天完成首次付费的独立用户数量/统计日期当天注册的用户总数，单位%；
	 *
	 */

	/**
	 * @return \VGPM\DB\LogStats
	 */
	static public function getDB() {
		return Common::DB('LogStats');
	}


	static public function ActiveUser($d, $sid) {

		$total = Model\LogLogin::getDB()->totalByDate($d, $sid);
		$id    = self::_todb('active_user', $d, $sid, $total);
	}


	static public function PayUser($d, $sid) {
		$total = Model\LogPay::getDB()->totalByGid($d, $sid);
		$id    = self::_todb('pay_user', $d, $sid, $total);
	}

	static public function OnlineUserTop($d, $sid) {
		$total = Model\LogOnline::getDB()->topByDate($d, $sid);
		$id    = self::_todb('online_user_top', $d, $sid, $total);
	}

	static public function OnlineUserAvg($d, $sid) {
		$total = Model\LogOnline::getDB()->avgByDate($d, $sid);
		$id    = self::_todb('online_user_avg', $d, $sid, $total);
	}


	static public function KeepLoginUser($d, $sid) {
		$t = strtotime($d);
		$d = date('Ymd', $t);

		$d1  = date('Ymd', $t - 86400);
		$d7  = date('Ymd', $t - 86400 * 7);
		$d30 = date('Ymd', $t - 86400 * 30);

		$gid_new = Model\Player::getDB()->newUser($d, $sid);

		$gid_1  = Model\LogLogin::getDB()->totalKeepUser($d1, $sid);
		$gid_7  = Model\LogLogin::getDB()->totalKeepUser($d7, $sid);
		$gid_30 = Model\LogLogin::getDB()->totalKeepUser($d30, $sid);

		//var_dump($gid_new, $gid_1);
		//var_dump(array_intersect($gid_new, $gid_1));
		//echo "==========================================".PHP_EOL;

		$total1  = count(array_intersect($gid_new, $gid_1));
		$total7  = count(array_intersect($gid_new, $gid_7));
		$total30 = count(array_intersect($gid_new, $gid_30));


		//var_dump($gid_1);
		//var_dump($gid_7);
		//var_dump($gid_30);
		$total = count($gid_new);
		$id    = self::_todb('keep_user_new', $d, $sid, $total);
		$id    = self::_todb('keep_user_1', $d, $sid, $total1);
		$id    = self::_todb('keep_user_7', $d, $sid, $total7);
		$id    = self::_todb('keep_user_30', $d, $sid, $total30);
	}


	static public function KeepPayUser($d, $sid) {

		$t   = strtotime($d);
		$d   = date('Ymd', $t);
		$d1  = date('Ymd', $t - 86400);
		$d7  = date('Ymd', $t - 86400 * 7);
		$d30 = date('Ymd', $t - 86400 * 30);


		$gid_new = Model\LogPay::getDB()->totalNewPayUser($d, $sid);

		$gid_1  = Model\LogPay::getDB()->totalKeepUser($d1, $sid);
		$gid_7  = Model\LogPay::getDB()->totalKeepUser($d7, $sid);
		$gid_30 = Model\LogPay::getDB()->totalKeepUser($d30, $sid);

		$total1  = count(array_intersect($gid_new, $gid_1));
		$total7  = count(array_intersect($gid_new, $gid_7));
		$total30 = count(array_intersect($gid_new, $gid_30));


		//var_dump($gid_1);
		//var_dump($gid_7);
		//var_dump($gid_30);
		$total = count($gid_new);
		$id    = self::_todb('pay_user_new', $d, $sid, $total);
		$id    = self::_todb('pay_user_1', $d, $sid, $total1);
		$id    = self::_todb('pay_user_7', $d, $sid, $total7);
		$id    = self::_todb('pay_user_30', $d, $sid, $total30);
	}

	static private function _todb($type, $d, $sid, $total) {
		$crc  = md5($type . $d . $sid);
		$data = [
			'type'      => $type,
			'date'      => $d,
			'num'       => $total,
			'server_id' => $sid,
			'crc'       => $crc,
		];
		$id   = 0;
		$info = Model\LogStats::getDB()->getBy(['crc' => $crc]);
		if (!empty($info['id'])) {
			$ret = Model\LogStats::getDB()->update($data, $info['id']);
			if ($ret) {
				$id = $info['id'];
			}
		} else {
			$id = Model\LogStats::getDB()->insert($data);
		}

		echo "{$d}-{$sid}-{$type}#{$total}-{$id}\n";

		return $id;
	}

}

?>