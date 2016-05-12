<?php
namespace VGPM\Com;

class Utils {
	static public function formatTime($uptime) {
		$day   = floor(($uptime / 86400) * 1.0);
		$calc1 = $day * 86400;
		$calc2 = $uptime - $calc1;
		$hour  = floor(($calc2 / 3600) * 1.0);

		$calc3 = $hour * 3600;
		$calc4 = $calc2 - $calc3;
		$min   = floor(($calc4 / 60) * 1.0);

		$calc5 = $min * 60;
		$sec   = floor(($calc4 - $calc5) * 1.0);

		$ret = '';
		if (!empty($day)) {
			$ret .= "{$day}D ";
		}
		if (!empty($hour)) {
			$ret .= "{$hour}H ";
		}
		if (!empty($min)) {
			$ret .= "{$min}M ";
		}
		if (!empty($sec)) {
			$ret .= "{$sec}S ";
		}
		return $ret;
	}


	static public function to($data) {
		$code = isset($data['code']) ? $data['code'] : 300;
		if ($code == 300) {
			if (!empty($data['message'])) {
				$message = Lang::T($data['message']);
			} else {
				$message = Lang::T("错误操作");
			}

		} else if ($code == 200) {
			if (!empty($data['message'])) {
				$message = Lang::T($data['message']);
			} else {
				$message = Lang::T("操作成功");
			}
		} else if ($code == 301) {
			$message = Lang::T("会话超时");
		}

		$out = array(
			'statusCode'   => isset($data['code']) ? $data['code'] : 300,
			'message'      => $message,
			'navTabId'     => isset($data['navTabId']) ? $data['navTabId'] : '',
			'rel'          => isset($data['rel']) ? $data['rel'] : '',
			'forwardUrl'   => isset($data['forwardUrl']) ? $data['forwardUrl'] : '',
			'callbackType' => isset($data['callbackType']) ? $data['callbackType'] : '',
		);
		echo json_encode($out);
		exit;
	}

	static public function out($flag, $navTabId = '', $callbackType = 'closeCurrent', $forwardUrl = '', $errMsg = '错误操作') {
		$out = array(
			'statusCode' => 300,
			'message'    => Lang::T($errMsg),
		);

		if ($flag == App::SUCC) {
			$out = array(
				'statusCode'   => 200,
				'message'      => Lang::T('操作成功'),
				'navTabId'     => $navTabId,
				'forwardUrl'   => $forwardUrl,
				'callbackType' => $callbackType,
			);
		} else if ($flag == App::NO_LOGIN) {
			$out = array(
				'statusCode' => 301,
				'message'    => Lang::T('会话超时'),
			);
		}
		echo json_encode($out);
		exit;
	}

	/**
	 * 分页html代码
	 * @author huwei on 20110922
	 *
	 * @param int $curPage     当前第几页
	 * @param int $toatlNum    总记录数
	 * @param int $perPageNum  每页记录数
	 * @param int $showPageNum 显示分页序号数量
	 *
	 * @return staring
	 */
	static public function pageHtml($curPage, $totalNum, $perPageNum, $showPageNum = 10) {
		if ($perPageNum == 20) {

		}

		$totalNum   = max(0, $totalNum);
		$perPageNum = max(10, $perPageNum);
		$curPage    = max(1, $curPage);

		$showName  = Lang::T('显示');
		$record    = Lang::T('记录');
		$recordAll = Lang::T('记录数量');

		$out = <<<eof
<div class="pages">
	<span>$showName</span>
	<select class="combox" name="numPerPage" change="navTabPageBreak" param="numPerPage">
		<option value="20">20</option>
		<option value="50">50</option>
	</select>
	<span>$record, $recordAll: $totalNum</span>
</div>
<div class="pagination" targetType="navTab" totalCount="$totalNum" numPerPage="$perPageNum" pageNumShown="$showPageNum" currentPage="$curPage"></div>
eof;
		return $out;
	}

	/**
	 * 计算分页的参数
	 * @author huwei on 20110922
	 * @return array [curPage,totalNum,totalPage,offsetNum,startNum]
	 */
	static public function calcPageParams($totalNum, $curPage, $offsetNum) {
		$offsetNum = max(10, $offsetNum);
		$totalPage = ($totalNum > 0) ? ceil($totalNum / $offsetNum) : 0;

		$curPage = max($curPage, 1);
		$curPage = min($curPage, $totalPage);

		$start = $offsetNum * $curPage - $offsetNum; // do not put $limit*($page - 1) 

		$startNum = max(0, $start);

		return array(
			'curPage'   => $curPage,
			'totalNum'  => $totalNum,
			'totalPage' => $totalPage,
			'offsetNum' => $offsetNum,
			'startNum'  => $startNum
		);
	}

	static public function txt($arr, $name) {
		return isset($arr[$name]) ? $arr[$name] : '';
	}

	/**
	 * 获取ip
	 * @author 胡威
	 * @return string
	 */
	static public function getIp() {
		$cip  = getenv('HTTP_CLIENT_IP');
		$xip  = getenv('HTTP_X_FORWARDED_FOR');
		$rip  = getenv('REMOTE_ADDR');
		$srip = $_SERVER['REMOTE_ADDR'];
		if ($cip && strcasecmp($cip, 'unknown')) {
			$onlineip = $cip;
		} elseif ($xip && strcasecmp($xip, 'unknown')) {
			$onlineip = $xip;
		} elseif ($rip && strcasecmp($rip, 'unknown')) {
			$onlineip = $rip;
		} elseif ($srip && strcasecmp($srip, 'unknown')) {
			$onlineip = $srip;
		}
		preg_match("/[\d\.]{7,15}/", $onlineip, $match);
		$onlineip = $match[0] ? $match[0] : 'unknown';
		return $onlineip;
	}

	/** 二维数组按某键值排序 */
	static public function array_sort_2D($arr, $keys, $type = 'asc') {
		$keysvalue = $new_array = array();
		foreach ($arr as $k => $v) {
			$keysvalue[$k] = $v[$keys];
		}
		if ($type == 'asc') {
			asort($keysvalue);
		} else {
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k => $v) {
			$new_array[$k] = $arr[$k];
		}
		return $new_array;
	}

}

?>