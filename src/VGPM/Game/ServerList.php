<?php
namespace VGPM\Game;

use VGPM\Model;

class ServerList extends Base {
	public function ARun() {
		$ver            = $this->getParam('ver');
		$ret['ver']     = $ver;
		$ret['updated'] = 0;
		$ret['rec']     = 1;

		$list = Model\ServerList::getDB()->getAll(['no' => 'asc']);
		$tmp  = [];
		foreach ($list as $val) {
			$tmp[] = [
				'nServerID'    => intval($val['no']),// 服务器ID
				'szServerName' => $val['name'],        //服务器名字
				'szServerIp'   => $val['host'],        // 服务器IP
				'nServerPort'  => intval($val['port']),        // 服务器端口
				'nState'       => intval($val['status']),        // 服务器状态		0 良好，1 普通， 2差
				'szDesc'       => 0,
			];
		}
		$ret['list']         = $tmp;
		$ret['updated_file'] = '';
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($ret, JSON_UNESCAPED_UNICODE);
		exit;
	}
}