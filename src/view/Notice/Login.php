<?php
$listUrl = CUR_URL . '?r=Notice/LoginList';
$editUrl = CUR_URL . '?r=Notice/LoginEdit&id=';
$delUrl  = CUR_URL . '?r=Notice/LoginDel&id=';
$height  = 450;
$fields  = [
	['display' => 'id', 'name' => 'id', 'width' => 60,],
	['display' => '开始时间', 'name' => 's_time', 'width' => 130,],
	['display' => '结束时间', 'name' => 'e_time', 'width' => 130,],
	['display' => '消息内容', 'name' => 'content', ' align' => 'left',],
	['display' => '状态', 'name' => 'status', 'width' => 60,],
	['display' => '添加者', 'name' => 'uid', 'width' => 80,],
	['display' => '更新时间', 'name' => 'updated_at', 'width' => 130,],

];

include(VIEW_PATH . '/list_tpl.php');
?>
<div id="toptoolbar">

</div>
<div id="maingrid" style="margin:0; padding:0"></div>