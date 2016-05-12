<?php
namespace VGPM\Cron;

use VGPM\Model;

class StatsLog {


	public function ARun() {
		$list = Model\ServerList::getDB()->getAll();
		for ($i = 1; $i < 7; $i++) {
			$d = date('Ymd', strtotime("-{$i} day"));
			foreach ($list as $val) {
				$sid   = $val['no'];

				Model\LogStats::ActiveUser($d,$sid);
				Model\LogStats::KeepPayUser($d,$sid);
				Model\LogStats::KeepLoginUser($d,$sid);
				Model\LogStats::OnlineUserAvg($d,$sid);
				Model\LogStats::OnlineUserTop($d,$sid);
				Model\LogStats::PayUser($d,$sid);

			}
		}
	}

	



}