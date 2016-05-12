<?php
$listUrl = CUR_URL.'?r=User/List';
$editUrl = CUR_URL.'?r=User/Edit&id=';
$delUrl = CUR_URL.'?r=User/Del&id=';

$fields = [
		['display'=>'用户ID','name'=>'id'],
		['display'=>'登录名称','name'=>'username'],
		['display'=>'显示名称','name'=>'nickname'],
		['display'=>'用户组','name'=>'group_id'],
		['display'=>'运营商','name'=>'consumer_ids'],
		['display'=>'添加时间','name'=>'created_at'],

];

include(VIEW_PATH.'/list_tpl.php');
?>
<div id="toptoolbar">

</div>
<div id="maingrid" style="margin:0; padding:0"></div>