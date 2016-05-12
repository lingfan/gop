<?php
$listUrl = CUR_URL . '?r=Mail/List';
$editUrl = CUR_URL . '?r=Mail/Edit&id=';
$delUrl  = CUR_URL . '?r=Mail/Del&id=';
$height  = 600;
$fields  = [
	['display' => 'id', 'name' => 'id', 'width' => 60,],
	['display' => '开始', 'name' => 's_time', 'width' => 130,],
	['display' => '结束', 'name' => 'e_time', 'width' => 130,],
	['display' => '标题', 'name' => 'name', ' align' => 'left',],
	['display' => '状态', 'name' => 'status', 'width' => 60,],
	['display' => '添加者', 'name' => 'uid', 'width' => 80,],
	['display' => '更新时间', 'name' => 'updated_at', 'width' => 130,],

];

include(VIEW_PATH . '/list_tpl.php');
?>
<div id="toptoolbar">

</div>
<div id="maingrid" style="margin:0; padding:0"></div>