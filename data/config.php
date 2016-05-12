<?php
/** 数据库配置 **/
$config['db'] = [
	'hostname' => '127.0.0.1',
	'database' => 'db',
	'username' => 'root',
	'password' => '',
	'port'     => '3306',
];

$config['redis'] = [
	'host' => '127.0.0.1',
	'port' => 6379,
];


$config['log_redis'] = [
	'host' => '127.0.0.1',
	'port' => 6379,
];


$config['wxpay'] = [
	'wxpay_url'        => 'https://api.mch.weixin.qq.com/pay/unifiedorder',//	微信支付api地址
	'wxpay_appid'      => '微信支付appid',    //微信支付appid
	'wxpay_appkey'     => '微信支付密钥',    //微信支付密钥
	'wxpay_mch_id'     => '微信支付商户id',    //微信支付商户id
	'wxpay_package'    => '微信支付包名',    //微信支付包名
	'wxpay_notify_url' => '微信支付回调地址',    //微信支付回调地址
];

return $config;
?>