<?php
namespace VGPM\Cmd;

use VGPM\Com\App;
use VGPM\Com\Menu;
use VGPM\Lib\Common;
use VGPM\Lib\View;

class Index extends Base {
	public function AIndex() {
		View::renderPartail('main');
	}


	public function AMenu() {
		$this->out(Menu::$data);
	}

	public function AContent() {
		echo 1;
		exit;
	}

	public function ALogout() {

		Common::redirect('?r=index/login');
	}


	public function ALogin() {

		$args     = array(
			'username' => FILTER_SANITIZE_STRING,
			'password' => FILTER_SANITIZE_STRING,
		);
		$formVals = filter_var_array($_REQUEST, $args);

		if (!empty($_POST) && !empty($formVals['username']) && !empty($formVals['password'])) {
			$info = MUser::verifyLogin($formVals['username'], md5($formVals['password']));

			if (!empty($info['id'])) {
				MAuth::setLoginCookie($info);
				Common::redirect('?r=index/index');
			}
		}
		View::renderPartail('Index/Login');
	}

	public function AMain() {
		View::renderPartail('Index/Main');
	}

	public function AInitData() {
		header('Content-Type:text/xml;charset=utf-8');
		View::renderPartail('Index/Xml');
	}


	public function AMenuList() {
		$ret = Menu::getList();
		$this->out($ret);
	}

	public function ARadioStatus() {
		$ret = [];
		foreach (App::$status as $k => $v) {
			$ret[] = ['id' => $k, 'text' => $v];
		}
		$this->out($ret);
	}

	public function AGoodsComboBox() {
		$ret    = [];
		$config = require CONFIG_PATH . '/goods.php';
		unset($config['data']['up_w_phase']);
		unset($config['data']['up_w_star']);
		unset($config['data']['up_h_star']);

		$key = $this->postParam('key');
		foreach ($config['data'] as $val) {
			if (empty($key) || stristr($val['szGoodsName'],$key)) {
				$ret[] = [
					'id'   => $val['lGoodsID'],
					'name' => $val['szGoodsName'],
				];
			}

		}
		//$this->out($ret);
		$this->outGrid(count($ret), $ret);

	}
}

?>