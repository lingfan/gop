<?php
namespace VGPM\Lib;


class WxPay {
	private $url;
	private $appid;
	private $appkey;
	private $mch_id;
	private $package;
	private $notify_url;
	private $timeout = 30;


	public function __construct() {
		$wxpayConf        = Config::get('wxpay');
		$this->url        = $wxpayConf['wxpay_url'];
		$this->appid      = $wxpayConf['wxpay_appid'];
		$this->appkey     = $wxpayConf['wxpay_appkey'];
		$this->mch_id     = $wxpayConf['wxpay_mch_id'];
		$this->package    = $wxpayConf['wxpay_package'];
		$this->notify_url = $wxpayConf['wxpay_notify_url'];

	}


	/**
	 * @param string $uid        用户 id
	 * @param float  $totalFee   收款总费用 单位元
	 * @param string $outTradeNo 唯一的订单号
	 * @param string $orderName  订单名称
	 *                           https://mp.weixin.qq.com/ 微信支付-开发配置-测试目录
	 *                           测试目录 http://mp.izhanlue.com/paytest/  最后需要斜线，(需要精确到二级或三级目录)
	 *
	 * @return string
	 */
	public function payUnifiedOrder($roleId, $totalFee, $outTradeNo, $orderName, $timestamp,$idx) {

		$unified = array(
			'appid'            => $this->appid,
			'attach'           => $roleId.'_'.$idx,             //商家数据包，原样返回
			'body'             => $orderName,
			'mch_id'           => $this->mch_id,
			'nonce_str'        => $this->createNonceStr(),
			'notify_url'       => $this->notify_url,
			'out_trade_no'     => $outTradeNo,
			'spbill_create_ip' => '127.0.0.1',
			'total_fee'        => intval($totalFee * 100),       //单位 转为分
			'trade_type'       => 'APP',
		);


		//var_dump($unified);
		$unified['sign'] = $this->getSign($unified, $this->appkey);

		$xml          = $this->arrayToXml($unified);
		$unifiedOrder = $this->post($xml);
		/*
		<xml>
		<return_code><![CDATA[SUCCESS]]></return_code>
		<return_msg><![CDATA[OK]]></return_msg>
		<appid><![CDATA[wx00e5904efec77699]]></appid>
		<mch_id><![CDATA[1220647301]]></mch_id>
		<nonce_str><![CDATA[1LHBROsdmqfXoWQR]]></nonce_str>
		<sign><![CDATA[ACA7BC8A9164D1FBED06C7DFC13EC839]]></sign>
		<result_code><![CDATA[SUCCESS]]></result_code>
		<prepay_id><![CDATA[wx2015032016590503f1bcd9c30421762652]]></prepay_id>
		<trade_type><![CDATA[JSAPI]]></trade_type>
		</xml>
		*/
		if ($unifiedOrder === false) {
			die('parse xml error');
		}

		if ($unifiedOrder['return_code'] != 'SUCCESS') {
			die($unifiedOrder['return_msg']);
			/*
			NOAUTH 商户无此接口权限
			NOTENOUGH 余额不足
			ORDERPAID 商户订单已支付
			ORDERCLOSED 订单已关闭
			SYSTEMERROR 系统错误
			APPID_NOT_EXIST   APPID不存在
			MCHID_NOT_EXIST MCHID不存在
			APPID_MCHID_NOT_MATCH appid和mch_id不匹配
			LACK_PARAMS 缺少参数
			OUT_TRADE_NO_USED 商户订单号重复
			SIGNERROR 签名错误
			XML_FORMAT_ERROR XML格式错误
			REQUIRE_POST_METHOD 请使用post方法
			POST_DATA_EMPTY post数据为空
			NOT_UTF8 编码格式错误
			*/
		}
		//$unifiedOrder->trade_type 交易类型 调用接口提交的交易类型，取值如下：JSAPI，NATIVE，APP
		//$unifiedOrder->prepay_id 预支付交易会话标识 微信生成的预支付回话标识，用于后续接口调用中使用，该值有效期为2小时
		//$unifiedOrder->code_url 二维码链接 trade_type为NATIVE是有返回，可将该参数值生成二维码展示出来进行扫码支付
		$arr         = array(
			'appid'     => $this->appid,
			'timestamp' => $timestamp,
			'noncestr'  => $this->createNonceStr(),
			'package'   => 'Sign=WXPay',
			'prepayid'  => $unifiedOrder['prepay_id'],
			'partnerid' => $this->mch_id,
		);
		$arr['sign'] = $this->getSign($arr, $this->appkey);


		//$arr['noncestr'] = $unified['nonce_str'];
		//$arr['paySign'] = $unified['sign'];


		return $arr;
	}

	public function notify($postStr) {
		error_log(json_encode($postStr) . PHP_EOL, 3, '/tmp/wxpay');
		$config = array(
			'mch_id' => $this->mch_id,
			'appid'  => $this->appid,
			'key'    => $this->appkey,
		);

		//error_log($postStr, 3, './str.txt');
		/*
		$postStr = '<xml>
		<appid><![CDATA[wx00e5904efec77699]]></appid>
		<attach><![CDATA[支付测试]]></attach>
		<bank_type><![CDATA[CMB_CREDIT]]></bank_type>
		<cash_fee><![CDATA[1]]></cash_fee>
		<fee_type><![CDATA[CNY]]></fee_type>
		<is_subscribe><![CDATA[Y]]></is_subscribe>
		<mch_id><![CDATA[1220647301]]></mch_id>
		<nonce_str><![CDATA[a0tZ41phiHm8zfmO]]></nonce_str>
		<openid><![CDATA[oU3OCt5O46PumN7IE87WcoYZY9r0]]></openid>
		<out_trade_no><![CDATA[550bf2990c51f]]></out_trade_no>
		<result_code><![CDATA[SUCCESS]]></result_code>
		<return_code><![CDATA[SUCCESS]]></return_code>
		<sign><![CDATA[F6F519B4DD8DB978040F8C866C1E6250]]></sign>
		<time_end><![CDATA[20150320181606]]></time_end>
		<total_fee>1</total_fee>
		<trade_type><![CDATA[APP]]></trade_type>
		<transaction_id><![CDATA[1008840847201503200034663980]]></transaction_id>
		</xml>';
		*/
		$arr = $this->xmlToArray($postStr);
		error_log(json_encode($arr) . PHP_EOL, 3, '/tmp/wxpay');

		if (empty($arr['return_code'])) {
			//die('parse xml error');
		}

		if ($arr['return_code'] != 'SUCCESS') {
			//die($arr['return_msg'] . '(' . $arr['err_code'] . ')');

		}

		$sign = $arr['sign'];
		unset($arr['sign']);
		if ($this->getSign($arr, $config['key']) == $sign) {
			// $mch_id = $postObj->mch_id; //微信支付分配的商户号
			// $appid = $postObj->appid; //微信分配的公众账号ID
			// $openid = $postObj->openid; //用户在商户appid下的唯一标识
			// $transaction_id = $postObj->transaction_id;//微信支付订单号
			// $out_trade_no = $postObj->out_trade_no;//商户订单号
			// $total_fee = $postObj->total_fee; //订单总金额，单位为分
			// $is_subscribe = $postObj->is_subscribe; //用户是否关注公众账号，Y-关注，N-未关注，仅在公众账号类型支付有效
			// $attach = $postObj->attach;//商家数据包，原样返回
			// $time_end = $postObj->time_end;//支付完成时间
			echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
			return $arr;
		}
		return false;
	}

	/**
	 *     array转xml
	 */
	public function arrayToXml($arr) {
		$xml = "<xml>";
		foreach ($arr as $key => $val) {
			$xml .= "<" . $key . ">" . $val . "</" . $key . ">";
			if (is_numeric($val)) {
				//$xml .= "<" . $key . ">" . $val . "</" . $key . ">";
			} else {
				//$xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
			}

		}
		$xml .= "</xml>";
		return $xml;
	}

	public function xmlToArray($str) {
		return (array)simplexml_load_string($str, 'SimpleXMLElement', LIBXML_NOCDATA);
	}

	/**
	 *     作用：使用证书，以post方式提交xml到对应的接口url
	 */
	public function post($xml) {


		$ch = curl_init();
		//超时时间
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

		//这里设置代理，如果有的话
		//curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
		//curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, false);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//设置证书
		//使用证书：cert 与 key 分别属于两个.pem文件
		//默认格式为PEM，可以注释
		//curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		//curl_setopt($ch, CURLOPT_SSLCERT, $cert);
		//默认格式为PEM，可以注释
		//curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		//curl_setopt($ch, CURLOPT_SSLKEY, $key);
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		//返回结果
		if ($data) {
			curl_close($ch);
			return $this->xmlToArray($data);
		} else {
			$error = curl_errno($ch);
			echo "curl出错，错误码:$error" . "<br>";
			curl_close($ch);
			return false;
		}
	}

	public function createNonceStr($length = 16) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$str   = '';
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}

	/**
	 * 例如：
	 * appid：  wxd930ea5d5a258f4f
	 * mch_id：  10000100
	 * device_info： 1000
	 * Body：  test
	 * nonce_str： ibuaiVcKdpRxkhJA
	 * 第一步：对参数按照 key=value 的格式，并按照参数名 ASCII 字典序排序如下：
	 * stringA="appid=wxd930ea5d5a258f4f&body=test&device_info=1000&mch_i
	 * d=10000100&nonce_str=ibuaiVcKdpRxkhJA";
	 * 第二步：拼接支付密钥：
	 * stringSignTemp="stringA&key=192006250b4c09247ec02edce69f6a2d"
	 * sign=MD5(stringSignTemp).toUpperCase()="9A0A8659F005D6984697E2CA0A9CF3B7"
	 */
	public function getSign($params, $key) {
		ksort($params, SORT_STRING);
		$unSignParaString = $this->formatQueryParaMap($params, false);
		$signStr          = strtoupper(md5($unSignParaString . "&key=" . $key));
		return $signStr;
	}

	protected function formatQueryParaMap($paraMap, $urlEncode = false) {
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v) {
			if (null != $v && "null" != $v) {
				if ($urlEncode) {
					$v = urlencode($v);
				}
				$buff .= $k . "=" . $v . "&";
			}
		}
		$reqPar = '';
		if (strlen($buff) > 0) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}
		return $reqPar;
	}

}