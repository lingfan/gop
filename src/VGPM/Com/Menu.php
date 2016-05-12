<?php
namespace VGPM\Com;

class Menu {
	static $data = [
		[
			'text'     => '数据统计',
			'isexpand' => true,
			'children' => [
				['text' => '单日充值统计表', 'url' => '?r=PayLog/DayLog', 'id' => 'PayLogDayLog'],
				['text' => '单日用户统计表', 'url' => '?r=Stats/Day', 'id' => 'StatsDay'],
				['text' => '分时在线数据', 'url' => '?r=Online/Hour', 'id' => 'OnlineHour'],
				['text' => '单日在线数据', 'url' => '?r=Online/Day', 'id' => 'OnlineDay'],
				['text' => '在线用户列表', 'url' => '?r=Online/Now', 'id' => 'OnlineNow'],
				['text' => '注册用户列表', 'url' => '?r=Player/Index', 'id' => 'PlayerIndex'],
				['text' => '玩家充值日志', 'url' => '?r=PayLog/UserLog', 'id' => 'PayLogUserLog'],
				['text' => '钻石消耗日志', 'url' => '?r=Stats/Cost', 'id' => 'StatsCost'],
				['text' => '消费分类统计', 'url' => '?r=Stats/CostType', 'id' => 'StatsCostType'],
			],
		],
		[
			'text'     => '玩家管理',
			'isexpand' => true,
			'children' => [
				['text' => '滚动消息设置', 'url' => '?r=Notice/Msg', 'id' => 'NoticeMsg'],
				['text' => '登录公告设置', 'url' => '?r=Notice/Login', 'id' => 'NoticeLogin'],
				['text' => '邮件群发消息', 'url' => '?r=Mail/Index', 'id' => 'MailIndex'],
				['text' => '道具使用记录', 'url' => '?r=Role/GoodsUseLog', 'id' => 'RoleGoodsUseLog'],
				['text' => '玩家登录历史', 'url' => '?r=Role/LoginHistory', 'id' => 'RoleLoginHistory'],
				['text' => '玩家操作记录', 'url' => '?r=Role/LogAction', 'id' => 'RoleLogAction'],
				['text' => '玩家数据包', 'url' => '?r=Role/LogPacket', 'id' => 'RoleLogPacket'],
			],
		],
		[
			'text'     => '系统管理',
			'isexpand' => true,
			'children' => [
				['text' => '服务器列表', 'url' => '?r=Server/Index', 'id' => 'ServerIndex'],
				['text' => '运营商管理', 'url' => '?r=Consumer/Index', 'id' => 'ConsumerIndex'],
				['text' => '用户管理', 'url' => '?r=User/Index', 'id' => 'UserIndex'],
				['text' => '用户权限', 'url' => '?r=User/Group', 'id' => 'UserGroup'],
			],
		],
	];

	static public function getList() {
		$ret = [];
		foreach (Menu::$data as $tmp) {
			foreach ($tmp['children'] as $val) {
				$ret[] = $val;
			}

		}
		return $ret;
	}

}