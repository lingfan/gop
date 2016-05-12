<?php
namespace VGPM\Cmd;

use VGPM\Com\App;
use VGPM\Lib\View;
use VGPM\Model;

class Mail extends Base {
	public function AIndex() {
		View::render('Mail/Index');
	}

	public function AList() {
		$page     = intval($this->postParam('page'));
		$pagesize = intval($this->postParam('pagesize'));
		$start    = (max($page, 1) - 1) * $pagesize;
		$total    = Model\Mail::getDB()->count();
		$list     = Model\Mail::getDB()->getList($start, $pagesize);

		foreach ($list as $k => $v) {
			$list[$k]['s_time']     = date('Y/m/d H:i:s', $v['s_time']);
			$list[$k]['e_time']     = date('Y/m/d H:i:s', $v['e_time']);
			$list[$k]['status']     = App::$status[$v['status']];
			$list[$k]['updated_at'] = date('Y/m/d H:i:s', $v['updated_at']);
		}

		$this->outGrid($total, $list);
	}

	public function AEdit() {
		$id = intval($this->getParam('id'));
		if (!empty($this->postParam('content'))) {
			$upData               = [
				's_time'     => strtotime($this->postParam('s_time')),
				'e_time'     => strtotime($this->postParam('e_time')),
				'uid'        => 1,
				'name'       => $this->postParam('name'),
				'content'    => $this->postParam('content'),
				'status'     => $this->postParam('status'),
				'server_ids' => $this->postParam('server_ids_val'),
				'role_ids'   => $this->postParam('role_ids'),
				'goods_ids'  => $this->postParam('goods_ids_val'),
			];
			$upData['updated_at'] = time();
			if (empty($this->postParam('id'))) {
				$upData['created_at'] = time();
				$ret                  = Model\Mail::getDB()->insert($upData);
			} else {
				$ret = Model\Mail::getDB()->update($upData, $this->postParam('id'));
			}

			if ($ret) {
				$this->outMsg(0, '成功');
			} else {
				$this->outMsg(1, '失败');
			}
		}

		$data = ['info' => []];


		$goods  = [];
		$config = require CONFIG_PATH . '/goods.php';
		unset($config['data']['up_w_phase']);
		unset($config['data']['up_w_star']);
		unset($config['data']['up_h_star']);

		$key = $this->postParam('key');
		foreach ($config['data'] as $val) {
			if (empty($key) || stristr($val['szGoodsName'], $key)) {
				$goods[] = [
					'id'   => $val['lGoodsID'],
					'name' => $val['szGoodsName'],
				];
			}

		}

		$ret = [
			'Rows'  => $goods,
			'Total' => count($goods),
		];


		$data['goods'] = json_encode($ret, JSON_UNESCAPED_UNICODE);
		if (!empty($id)) {
			$data['info'] = Model\Mail::getDB()->get($id);
		}


		View::render('Mail/Edit', $data);
	}

	public function ADel() {
		$id  = intval($this->getParam('id'));
		$ret = Model\Mail::getDB()->delete($id);
		if ($ret) {
			$this->outMsg(0, '成功');
		} else {
			$this->outMsg(1, '失败');
		}
	}

}