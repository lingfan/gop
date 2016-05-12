<?php
namespace VGPM\Api;

use VGPM\Lib;
use VGPM\Model;

class WxPay extends Base {

	/**
	 * 统一下单接口
	 */
	public function AUnifiedOrder() {
		$wxpay = new Lib\WxPay();

		$uid = $this->getParam('uid');
		$rmb = $this->getParam('rmb');
		$idx = $this->getParam('idx');
		$num = $this->getParam('num');
		
		$info = Model\Player::getDB()->get($uid);
		if (empty($info)) {
			$this->out([]);
		}

		$totalFee   = $rmb;
		$time       = explode(" ", microtime());
		$mt         = floor($time[0] * 1000);
		$outTradeNo = date('YmdHis') . $mt;
		$orderName  = '购买砖石' . $num;
		$timestamp  = time();

		$data = $wxpay->payUnifiedOrder($uid, $totalFee, $outTradeNo, $orderName, $timestamp, $idx);

		$add = [
			'player_id'   => $uid,
			'server_id'   => intval($info['server_id']),
			'consumer_id' => intval($info['consumer_id']),
			'order_no'    => $outTradeNo,
			'amount'      => $rmb,
			'num'         => intval($num),
			'created_at'  => date('Y-m-d H:i:s'),
			'status'      => 0,
			'date'        => date('Ymd'),
			'mark'        => json_encode($data, JSON_UNESCAPED_UNICODE),
		];

		$id = Model\LogPay::getDB()->insert($add);

		$this->out($data);
	}


	/**
	 * 微信支付回调接口
	 * @return bool
	 */
	public function ANotify() {

		$content = file_get_contents("php://input");
		Lib\Logger::debug($content);
		$wxpay = new Lib\WxPay();
		$ret   = $wxpay->notify($content);

		if (empty($ret)) {
			Lib\Logger::error(__METHOD__ . ':' . $content);
			//return false;
		}

		$where         = ['order_no' => $ret['out_trade_no']];
		$row           = Model\LogPay::getDB()->getBy($where);
		$row['status'] = 0;
		Lib\Logger::debug($row);
		Lib\Logger::debug($ret);

		if (!empty($row['id']) && $row['status'] == 0) {

			list($playerId, $idx) = explode('_', $ret['attach']);
			$params = ['idx' => $idx, 'role_id' => $row['player_id'], 'order_id' => $row['id']];
			Lib\VgClient::call($row['server_id'], 'WxPayNotify', $params);

			if (!empty($ret['transaction_id'])) {
				$up = [
					'transaction_id' => $ret['transaction_id'],
					'updated_at'     => date('Y-m-d H:i:s', strtotime($ret['time_end'])),
					'status'         => 1,
					'resp'           => json_encode($ret, JSON_UNESCAPED_UNICODE),
				];
				Model\LogPay::getDB()->update($up, $row['id']);
			}

		}
		exit;
	}

}