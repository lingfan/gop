<?php
namespace VGPM\Com;

/**
 * 应用常量
 */
class App {
	/** 失败 */
	const FAIL = 0;
	/** 成功 */
	const SUCC = 1;
	/** 正常 */
	const NORMAL = 2;
	/** 失败 */
	const NO_LOGIN = 3;

	static $status = [0 => '关闭', 1 => '开启'];

}