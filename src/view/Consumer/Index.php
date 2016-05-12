<?php
$listUrl = CUR_URL . '?r=Consumer/List';
$editUrl = CUR_URL . '?r=Consumer/Edit&id=';
$delUrl  = CUR_URL . '?r=Consumer/Del&id=';

$fields = [
		['display'=>'ID','name'=>'id','width'=>"60"],
		['display'=>'运营商名称','name'=>'name','width'=>"120"],
		['display'=>'运营商编号','name'=>'code','width'=>"120"],
		['display'=>'服务器数量','name'=>'server_num','width'=>"80"],

];

include(VIEW_PATH.'/list_tpl.php');
?>
<div id="toptoolbar">

</div>
<div id="maingrid" style="margin:0; padding:0"></div>
